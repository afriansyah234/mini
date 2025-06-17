<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Project;
use App\Models\Deadline;
use App\Models\Karyawan;
use App\Models\Status_tugas;
use App\Models\KategoriTugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Tugas::with(['status', 'project']);

        // Search by keyword
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_tugas', 'like', "%{$search}%")
                    ->orWhere('deskripsi', 'like', "%{$search}%")
                    ->orWhereHas('status', function ($q) use ($search) {
                        $q->where('nama_status', 'like', "%{$search}%");
                    })
                    ->orWhereHas('project', function ($q) use ($search) {
                        $q->where('nama_project', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by priority
        if ($request->has('prioritas') && $request->prioritas != '') {
            $query->where('prioritas', $request->prioritas);
        }

        // Filter by project
        if ($request->has('project_id') && $request->project_id != '') {
            $query->where('project_id', $request->project_id);
        }

        $tugass = $query->paginate(10);
        $projects = Project::all(); // Untuk dropdown filter project

        return view('tugas.index', compact('tugass', 'projects'));
    }

    /** 
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $project = Project::findOrFail(request()->project_id);
        $statuses = Status_tugas::all();
        $anggota = $project->anggota()->get(); // Ambil anggota saja, bukan penanggung jawab
        return view('tugas.create', compact('project', 'statuses', 'anggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi,krisis',
            'status_tugas_id' => 'required|exists:status_tugas,id',
            'deadline' => 'required|date|after:today',
            'karyawan_id' => 'required|exists:karyawans,id',

        ]);
        $project = Project::with('anggota')->findOrFail($validated['project_id']);

        // Validasi apakah karyawan_id adalah anggota (bukan penanggung jawab)
        $isAnggota = $project->anggota
            ->where('id', $validated['karyawan_id'])
            ->where('id', '!=', $project->karyawan_id)
            ->isNotEmpty();


        if (!$isAnggota) {
            return back()->withErrors(['karyawan_id' => 'Karyawan bukan anggota (atau dia adalah penanggung jawab).'])->withInput();
        }

        $deadline = Deadline::firstOrCreate(['tanggal' => $request->deadline]);

        Tugas::create([
            'project_id' => $validated['project_id'],
            'judul_tugas' => $validated['judul_tugas'],
            'deskripsi' => $validated['deskripsi'],
            'prioritas' => $validated['prioritas'],
            'status_tugas_id' => $validated['status_tugas_id'],
            'deadline_id' => $deadline->id,
            'karyawan_id' => $validated['karyawan_id'],

        ]);

        return redirect()->route('project.show', $validated['project_id'])->with('success', 'Tugas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tugas $tugas)
    {
        return view('tugas.index', compact('tugas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tugas $tugas)
    {
        $project = $tugas->project;
        $statuses = Status_tugas::all();
        $karyawan = Karyawan::all();
        $deadline = $tugas->deadline ? $tugas->deadline->tanggal->format('Y-m-d') : null;
        return view('tugas.edit', compact('tugas', 'project', 'statuses', 'deadline', 'karyawan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tugas $tugas)
    {
        $validated = $request->validate([
            'judul_tugas' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'prioritas' => 'required|in:rendah,sedang,tinggi,krisis',
            'status_tugas_id' => 'required|exists:status_tugas,id',
            'deadline' => 'required|date|after:today',
            'karyawan_id' => 'required|exists:karyawans,id'
        ]);

        $deadline = Deadline::firstOrCreate(['tanggal' => $validated['deadline']]);

        $tugas->update([
            'judul_tugas' => $validated['judul_tugas'],
            'deskripsi' => $validated['deskripsi'],
            'prioritas' => $validated['prioritas'],
            'status_tugas_id' => $validated['status_tugas_id'],
            'deadline_id' => $deadline->id,
            'karyawan_id' => $validated['karyawan_id'],

        ]);

        // Redirect ke project.show dengan project_id dari tugas yang diupdate
        return redirect()->route('project.show', $tugas->project_id)
            ->with('success', 'Tugas berhasil diperbarui');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tugas $tugas)
    {
        try {
            $project_id = $tugas->project_id; // Simpan project_id sebelum menghapus
            $deadline = $tugas->deadline;

            $tugas->delete();

            // Hapus deadline jika tidak ada tugas lain yang menggunakan
            if ($deadline && $deadline->tugas()->count() === 0) {
                $deadline->delete();
            }

            // Redirect ke halaman project yang sesuai
            return redirect()->route('project.show', $project_id)
                ->with('success', 'Tugas berhasil dihapus');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus tugas: ' . $e->getMessage());
        }
    }

    public function history()
    {
        $tugas = Tugas::whereHas('status', function ($query) {
            $query->where('nama_status', 'selesai');
        })->with(['status', 'karyawan', 'deadline'])->get();

        return view('tugas.history', compact('tugas'));
    }


}
