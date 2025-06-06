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
                    ->when($search, function($query, $search) {
                        return $query->where('nama_karyawan', 'like', "%{$search}%")
                                    ->orWhere('email', 'like', "%{$search}%")
                                    ->orWhere('departemen', 'like', "%{$search}%");
                    })
                    ->get();
        return view('karyawan.index', compact('karyawans','departemen'));
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
       $departemen =  Departemen::firstOrCreate([
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
    public function update(Request $request, $id)
    {
        $validasi = $request->validate([
            'nama_karyawan' => 'required',
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
