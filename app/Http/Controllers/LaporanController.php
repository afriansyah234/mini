<?php

namespace App\Http\Controllers;

use App\Models\Lampiran;
use App\Models\Laporan;
use App\Models\Project;
use App\Models\StatusLaporan;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class LaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $laporans = Laporan::with(['project', 'karyawan', 'lampiran'])->get();
        return view('laporan.index', compact('laporans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
{
    $project = Project::with('karyawan')->findOrFail($id); // ini penting
    return view('laporan.create', compact('project'));
}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'project_id' => 'exists:projects,id',
            'karyawan_id' => 'exists:karyawans,id',
            'deskripsi_laporan' => 'nullable|string',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:5120' // 5MB
        ]);
        $validated['tanggal_laporan'] = now()->toDateString();// Atur tanggal laporan ke tanggal saat ini
        $validated['statuslaporan'] = 'sedang di cek';

        // Simpan data laporan utama TANPA lampiran
        $laporan = Laporan::create($validated);

        // Proses upload lampiran jika ada
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $path = $file->store('file_laporan', 'public'); // Simpan di storage/app/public/file_laporan

                // Simpan info file ke tabel lampiran
                Lampiran::create([
                    'laporan_id' => $laporan->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'path' => $path,
                    'ukuran' => $file->getSize(),
                    'jenis' => $file->getClientOriginalExtension()
                ]);
            }
        }

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $laporan = Laporan::findOrFail($id);
        return view('laporan.show', compact( 'laporan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        $project = Project::with('karyawan')->findOrFail($laporan->project_id);
    $laporan->load('lampiran');

    return view('laporan.edit', [
        'laporan' => $laporan,
        'project' => $project,
        'karyawans' => Karyawan::all()
    ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Laporan $laporan)
    {
        $validated = $request->validate([
            'project_id' => 'exists:projects,id',
            'karyawan_id' => 'exists:karyawans,id',
            'statuslaporan' => 'required|string',
            'deskripsi_laporan' => 'nullable|string',
        ]);
        $laporan->update($validated);
        // Proses upload lampiran jika ada
        if ($request->hasFile('lampiran')) {
            foreach ($request->file('lampiran') as $file) {
                $path = $file->store('file_laporan', 'public'); // Simpan di storage/app/public/file_laporan

                // Simpan info file ke tabel lampiran
                Lampiran::create([
                    'laporan_id' => $laporan->id,
                    'nama_file' => $file->getClientOriginalName(),
                    'path' => $path,
                    'ukuran' => $file->getSize(),
                    'jenis' => $file->getClientOriginalExtension()
                ]);
            }
        }
        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporan = Laporan::findOrFail($id);
        $laporan->lampiran()->delete();
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'laporan sudah dihapus');
    }
}
