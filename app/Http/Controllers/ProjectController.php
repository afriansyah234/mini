<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Project;
use App\Models\Status_tugas;
use App\Models\StatusProject;
use App\Models\Tugas;
use App\Models\KategoriTugas;
use App\Models\Deadline;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $today = now()->startOfDay();

        $projects = Project::whereHas('status', function ($query) {
            $query->where('status_project', '!=', 'selesai');
        })->get();


        $projectsSebelumDeadline = $projects->filter(function ($project) use ($today) {
            return !$project->deadline || $project->deadline >= $today;
        });

        $projectsTelat = $projects->filter(function ($project) use ($today) {
            return $project->deadline && $project->deadline < $today;
        });

        return view('project.index', compact('projectsSebelumDeadline', 'projectsTelat', 'projects'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawans = Karyawan::with('departemen')->get();
        $statuss = StatusProject::all();
        return view('project.create', compact('karyawans', 'statuss'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_project' => 'required|string',
            'karyawan_id' => 'required|exists:karyawans,id',
            'status_project' => 'required|exists:status_projects,id',
            'deskripsi' => 'required|string',
            'deadline' => 'required|date|after_or_equal:today',
            'anggota_id' => 'required|array',
            'anggota_id.*' => 'exists:karyawans,id',
            'kategori_tugas' => 'required|string' // Tagify mengirim dalam bentuk JSON string
        ]);

        $project = Project::create([
            'nama_project' => $request->nama_project,
            'karyawan_id' => $request->karyawan_id,
            'status_project' => $request->status_project,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
        ]);

        $anggota = collect($request->anggota_id)->filter(fn($id) => $id != $request->karyawan_id);
        $project->anggota()->attach($anggota);

        // Decode kategori_tugas (string JSON Tagify)
        $kategoriArr = json_decode($request->input('kategori_tugas'), true);

        // Cek duplikat dalam input
        $values = array_map(fn($item) => trim(strtolower($item['value'])), $kategoriArr);
        if (count($values) !== count(array_unique($values))) {
            return redirect()->back()->withInput()->withErrors(['kategori_tugas' => 'Kategori tugas tidak boleh duplikat.']);
        }

        // Simpan ke DB setelah cek duplikat di dalam project
        foreach ($kategoriArr as $kategori) {
            $exists = KategoriTugas::where('project_id', $project->id)
                ->whereRaw('LOWER(nama_kategori) = ?', [strtolower($kategori['value'])])
                ->exists();

            if (!$exists) {
                KategoriTugas::create([
                    'project_id' => $project->id,
                    'nama_kategori' => $kategori['value'],
                ]);
            }
        }

        return redirect()->route('project.index')->with('success', 'Project berhasil dibuat');
    }




    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        // Tambahkan logika ini sebelum mengirim ke view
        $telatStatusId = Status_tugas::where('nama_status', 'telat')->value('id');



        foreach ($project->tugas as $tugas) {
            if (
                $tugas->deadline &&
                $tugas->deadline->tanggal < now() &&
                $tugas->status->nama_status !== 'selesai' &&
                $tugas->status->nama_status !== 'telat'
            ) {
                $tugas->status_tugas_id = $telatStatusId;
                $tugas->save();
            }
        }

        $statuses = Status_tugas::all(); // kirim juga untuk dropdown

        return view('project.show', compact('project', 'statuses', ));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $karyawans = Karyawan::with('departemen')->get();
        $statuss = StatusProject::all();
        $project->load('anggota'); // Load relasi anggota

        $kategoriTugas = KategoriTugas::where('project_id', $project->id)->get();
        $kategoriTugasJson = $kategoriTugas->map(fn($k) => ['value' => $k->nama_kategori]);

        return view('project.edit', compact('project', 'karyawans', 'statuss', 'kategoriTugasJson'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'nama_project' => 'required|string',
            'karyawan_id' => 'required|exists:karyawans,id',
            'status_project' => 'required|exists:status_projects,id',
            'deskripsi' => 'required|string',
            'deadline' => 'required|date|after_or_equal:today',
            'anggota_id' => 'required|array',
            'anggota_id.*' => 'exists:karyawans,id',
            'kategori_tugas' => 'required|string'
        ]);

        $project->update([
            'nama_project' => $request->nama_project,
            'karyawan_id' => $request->karyawan_id,
            'status_project' => $request->status_project,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline, 
        ]);

        // Sinkronisasi anggota
        $anggota = collect($request->anggota_id)->filter(fn($id) => $id != $request->karyawan_id);
        $project->anggota()->sync($anggota);

        // Update kategori tugas
        $kategoriArr = json_decode($request->input('kategori_tugas'), true);
        $values = array_map(fn($item) => trim(strtolower($item['value'])), $kategoriArr);

        if (count($values) !== count(array_unique($values))) {
            return back()->withInput()->withErrors(['kategori_tugas' => 'Kategori tugas tidak boleh duplikat.']);
        }

        // Hapus lama dan masukkan ulang
        KategoriTugas::where('project_id', $project->id)->delete();

        foreach ($kategoriArr as $kategori) {
            KategoriTugas::create([
                'project_id' => $project->id,
                'nama_kategori' => $kategori['value'],
            ]);
        }

        return redirect()->route('project.index')->with('success', 'Project berhasil diperbarui');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        if ($project->tugas()->exists()) {
            return redirect()->route('project.index')->with('error', 'Project tidak dapat dihapus karena memiliki tugas terkait.');
        }
        if ($project->laporan()->exists()) {
            return redirect()->route('project.index')->with('error', 'Project tidak dapat dihapus karena memiliki laporan terkait.');
        }
        $project->delete();
        return redirect()->route('project.index')->with('success', 'Project terhapus');
    }



    public function updateStatus(Request $request, Tugas $tugas)
    {
        $validated = $request->validate([
            'status_tugas_id' => 'required|exists:status_tugas,id'
        ]);

        $tugas->update($validated);

        return redirect()->route('project.show', $tugas->project_id)
            ->with('success', 'Status tugas berhasil diperbarui!');
    }


    public function history()
    {
        $projects = Project::whereHas('status', function ($query) {
            $query->where('status_project', 'selesai');
        })->get();

        return view('project.history', compact('projects'));
    }
    public function detail($id)
    {
        $project = Project::with('tugas.status')->findOrFail($id); // pastikan eager loading
        $penanggungjawab = $project->penanggungjawab;
        $anggota = $project->anggota;

        // Untuk chart
        $statusSelesaiId = Status_tugas::where('nama_status', 'selesai')->value('id');

        $totaltugas = $project->tugas->count();
        $tugasselesai = $project->tugas->where('status_tugas_id', $statusSelesaiId)->count();
        $tugasbelumselesai = $totaltugas - $tugasselesai;

        return view('project.detail', compact(
            'project',
            'anggota',
            'penanggungjawab',
            'totaltugas',
            'tugasselesai',
            'tugasbelumselesai'
        ));
    }


    public function historyDetail(Project $project)
    {
        // Pastikan hanya bisa diakses jika status project-nya 'selesai'
        if (!$project->status || $project->status->status_project !== 'selesai') {
            abort(403, 'Project ini belum selesai');
        }

        $tugas = $project->tugas()->with('status')->get(); // ambil semua tugas terkait
        return view('project.history-detail', compact('project', 'tugas'));
    }


}
