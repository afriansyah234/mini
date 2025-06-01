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
    public function create()
    {
        $laporans = Laporan::all();
        $projects = Project::all();
        $karyawans = Karyawan::all();
        return view('laporan.create', compact('laporans', 'projects', 'karyawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'atas_nama' => 'required|exists:karyawans,id',
            'deskripsi_laporan' => 'nullable|string',
            'lampiran.*' => 'file|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx|max:5120' // 5MB
        ]);

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
        $statuslaporans = StatusLaporan::all();
        $laporans = Laporan::findOrFail($id);
        return view('laporan.show', compact('statuslaporan', 'laporans'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Laporan $laporan)
    {
        $statuslaporan = StatusLaporan::all();
        return view('laporan.edit', compact('laporan', 'statuslaporan'));
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
        return redirect()->route('laporan.index')->with('success', 'Status Telah di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $laporan = Project::findOrFail($id);
        $laporan->delete();
        return redirect()->route('laporan.index')->with('success', 'laporan sudah dihapus');
    }

    public function selesai(Laporan $laporan)
    {
        // Asumsikan kamu punya status dengan id tertentu untuk 'Selesai', misalnya id = 2
        $laporan->status_laporan_id = 'selesai'; // ganti sesuai ID status 'Selesai' di tabel status_laporans
        $laporan->save();

        return redirect()->route('laporan.index')->with('success', 'Laporan berhasil diselesaikan.');
    }
}
