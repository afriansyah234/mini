<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $karyawans = Karyawan::all();
        return view('manajemen_karyawan.index', compact('karyawans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $karyawans = Karyawan::all();
        return view('manajemen_karyawan.create', compact('karyawans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validasi = $request->validate([
            'Nama_karyawan' => 'required',
            'email' => 'required|email|unique:karyawans,email',
            'departemen' => 'required'
        ]);
        Karyawan::create($validasi);
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
        return view('manajemen_karyawan.edit', compact('karyawans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validasi = $request->validate([
            'Nama_karyawan' => 'required',
            'email' => 'required',
            'departemen' => 'required'
        ]);

        $karyawans = Karyawan::findOrFail($id);
        $karyawans->update($validasi);

        return redirect()->route('karyawan.index')->with('success', 'karyawan bertambah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            Karyawan::findOrFail($id)->delete();
            return redirect()->route('karyawan.index')->with('success', 'karyawan berhasil dihapus');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'tidak berhasil');
        }
    }
}
