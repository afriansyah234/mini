<?php

namespace App\Http\Controllers;

use App\Models\Tugas;
use App\Models\Project;
use App\Models\Deadline;
use App\Models\Status_tugas;
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
            'status_tugas_id' => 'required|exists:status_tugas,id',
            'deadline' => 'required|date'
        ]);

        $deadline = Deadline::firstOrCreate(['tanggal' => $request->deadline]);

        Tugas::create([
            'project_id' => $validated['project_id'],
            'judul_tugas' => $validated['judul_tugas'],
            'deskripsi' => $validated['deskripsi'],
            'prioritas' => $validated['prioritas'],
            'status_tugas_id' => $validated['status_tugas_id'],
            'deadline_id' => $deadline->id
        ]);

        return redirect()->route('project.index')->with('success', 'Tugas berhasil ditambahkan');
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
