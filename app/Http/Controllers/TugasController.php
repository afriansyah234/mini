<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Project;
use App\Models\Status_tugas;
use Illuminate\Http\Request;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tugass = Tugas::with(['status', 'project'])->get();
        return view('tugas.index', compact('tugass'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::all();
        $statuses = Status_tugas::all();
        return view('tugas.create', compact('projects', 'statuses'));
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
            'status_tugas_id' => 'required|exists:status_tugas,id'
        ]);

        Tugas::create($validated);

        return redirect()->route('tugas.index')->with('success', 'Tugas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Tugas $tugas)
    {
        $tugas = Tugas::all();
        return view('tugas.index', compact('tugas'))
        ;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tugas $tugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tugas $tugas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tugas $tugas)
    {
        //
    }
}
