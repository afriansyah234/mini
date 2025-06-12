<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Project;
use App\Models\Status_tugas;
use App\Models\StatusProject;
use App\Models\Tugas;
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
        ]);

        $project = Project::create([
            'nama_project' => $request->nama_project,
            'karyawan_id' => $request->karyawan_id,
            'status_project' => $request->status_project,
            'deskripsi' => $request->deskripsi,
            'deadline' => $request->deadline,
        ]);
        $anggota = collect($request->anggota_id)->filter(function ($id) use ($request) {
            return $id != $request->karyawan_id;
        });
        $project->anggota()->attach($anggota);

        

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

        return view('project.show', compact('project', 'statuses',));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $statusProjects = StatusProject::all();
        $karyawans = Karyawan::all();

        return view('project.edit', compact('project', 'statusProjects', 'karyawans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'nama_project' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'status_project' => 'required|exists:status_projects,id',
            'karyawan_id' => 'required|exists:karyawans,id'
        ]);

        $project->update([
            'nama_project' => $validated['nama_project'],
            'deskripsi' => $validated['deskripsi'],
            'status_project' => $validated['status_project'],
            'karyawan_id' => $validated['karyawan_id']
        ]);

        return redirect()->route('project.index')
            ->with('success', 'Project update berhasil.');
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
     $project = Project::with(['tugas.status'])->findOrFail($id); // penting: eager load 'status'
    $penanggungjawab = $project->penanggungjawab;
    $anggota = $project->anggota;

    $totaltugas = $project->tugas->count();

    $tugasselesai = $project->tugas->filter(function($tugas) {
        return $tugas->status && $tugas->status->nama_status === 'selesai';
    })->count();

    $tugasbelumselesai = $totaltugas - $tugasselesai;

    return view('project.detail', compact(
        'project', 'anggota', 'penanggungjawab',
        'totaltugas', 'tugasselesai', 'tugasbelumselesai'
    ));
    }
}