<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects =Project::all();
        $karyawans = Karyawan::all();
        return view('project.index', compact('projects','karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $karyawans = Karyawan::all();
        return view('project.create',compact('karyawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'nama_project'=>'required|string',
            'deskripsi'=>'required|string',
            'status_project'=>'nullable|string',
            'karyawan_id'=>'required|exists:karyawans,id'
        ]);
        Project::create([
            'nama_project'=>$validated['nama_project'],
            'deskripsi'=>$validated['deskripsi'],
            'status_project'=>'',
            'karyawan_id'=>$validated['karyawan_id']
        ]);
        return redirect()->route('project.index')->with('success','Project berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       $project = Project::findOrFail($id);
       return view('project.show',compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        $karyawan = Karyawan::all();
        return view('project.edit',compact('project','karyawans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([

            'nama_project'=>'required|string',
            'deskripsi'=>'required|string',
            'status_project'=>'nullable|string',
            'karyawan_id'=>'required|exist:karyawans,id'
        ]);
        $project = Project::findOrFail($id);
        $project->update($validated);
        return redirect()->route('project.index')->with('success','Project berhasil di perbaharui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect()->route('project.index')->with('success','Project ke hapus mas');
    }
}
