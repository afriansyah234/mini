<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Project;
use App\Models\StatusLaporan;
use App\Models\Tugas;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporans = Laporan::all();
        return view('laporan.index',compact('laporans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $laporans = Laporan::all();
        return view('laporan.create',compact('laporans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'tugas_id' => 'required|exists:tugas,id',
            'atas_nama' => 'required|string',
            'deskripsi_laporan' => 'nullable|string'

        ]);
        $validated['tanggal_laporan'] = now()->toDateString();
        $project = Project::findOrFail($validated['project_id']);
        $tugas = Tugas::findOrFail($validated['tugas_id']);
        $laporan = Laporan::create($validated);
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil disimpan.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $statuslaporans = StatusLaporan::all();
        $laporans = Laporan::findOrFail($id);
        return view('laporan.show',compact('statuslaporan','laporans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        $statuslaporan = StatusLaporan::all();
        return view('laporan.edit',compact('laporan','statuslaporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'status_laporan_id' => 'required|exits:status_laporan,id'
        ]);
        $laporan->update(); 
        return redirect()->route('laporan.index')->with('success','Status Telah di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporan = Project::findOrFail($id);
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success','laporan sudah dihapus');
    }

    public function selesai(Laporan $laporan)
{
    // Asumsikan kamu punya status dengan id tertentu untuk 'Selesai', misalnya id = 2
    $laporan->status_laporan_id = 'selesai'; // ganti sesuai ID status 'Selesai' di tabel status_laporans
    $laporan->save();

    return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diselesaikan.');
}
}
