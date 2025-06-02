<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Project;
use App\Models\StatusProject;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with(['status', 'karyawan'])->latest()->get();

        return view('project.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawans = Karyawan::all();
        $statuss = StatusProject::all();
        return view('project.create', compact('karyawans', 'statuss'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_project' => 'required|string',
            'deskripsi' => 'required|string',
            'status_project' => 'required|exists:status_projects,id', // Sesuai nama kolom
            'karyawan_id' => 'required|exists:karyawans,id'
        ]);

        Project::create([
            'nama_project' => $validated['nama_project'],
            'deskripsi' => $validated['deskripsi'],
            'status_project' => $validated['status_project'], // Sesuai nama kolom
            'karyawan_id' => $validated['karyawan_id'],
        ]);
        return redirect()->route('project.index')->with('success', 'Project berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $project = Project::findOrFail($id);
        return view('project.show', compact('project'));
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
            ->with('success', 'Project updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect()->route('project.index')->with('success', 'Project ke hapus mas');
    }
}
