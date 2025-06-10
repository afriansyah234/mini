<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $karyawans = Karyawan::all();
        $departemen = Departemen::all();
        $search = $request->input('search');
        $karyawans = Karyawan::query()
            ->when($search, function ($query, $search) {
                return $query->where('nama_karyawan', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('departemen', 'like', "%{$search}%");
            })
            ->get();
        return view('karyawan.index', compact('karyawans', 'departemen'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawans = Karyawan::all();
        return view('karyawan.create', compact('karyawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'nama_karyawan' => 'required',
            'email' => 'required|email|unique:karyawans,email',
            'departemen' => 'required|string'
        ]);
        $departemen = Departemen::firstOrCreate([
            'nama_departemen' => $request->departemen
        ]);
        Karyawan::create([
            'nama_karyawan' => $validasi['nama_karyawan'],
            'email' => $validasi['email'],
            'departemen_id' => $departemen->id // Asumsi ada relasi ke tabel departemen
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $karyawans = Karyawan::all();
        $karyawans = Karyawan::findOrFail(id: $id);
        return view('karyawan.edit', compact('karyawans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validasi = $request->validate([
            'nama_karyawan' => 'required',
            'email' => 'required|email|unique:karyawans,email,' . $karyawan->id,
            'departemen' => 'required|string'
        ]);

        // Cari atau buat departemen baru
        $departemen = Departemen::firstOrCreate([
            'nama_departemen' => $request->departemen
        ]);

        // Update data karyawan
        $karyawan->update([
            'nama_karyawan' => $validasi['nama_karyawan'],
            'email' => $validasi['email'],
            'departemen_id' => $departemen->id
        ]);

        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $karyawan = Karyawan::findOrFail($id);

            if ($karyawan->project()->exists() || $karyawan->tugas()->exists()) {
                return redirect()->back()->with('error', 'Karyawan masih digunakan di tabel lain.');
            }

            $karyawan->delete();

            return redirect()->route('karyawan.index')->with('success', 'Karyawan berhasil dihapus.');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Terjadi kesalahan, tidak berhasil menghapus.');
        }
    }

}
