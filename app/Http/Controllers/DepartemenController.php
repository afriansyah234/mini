<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;

class DepartemenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departemens = Departemen::all();
        return view('departemen.index', compact('departemens'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('departemen.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_departemen'=> 'required|string',
        ]);
        Departemen::create([
            'nama_departemen'=> $request->nama_departemen,
        ]);
        return redirect()->route('departemen.index')->with('success', 'Departemen Berhasil di buat');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $departemen = Departemen::findOrFail($id);
        $departemen->delete();
        return redirect()->route('departemen.index')->with('success','Departemen Berhasil di hapus');

    }
}
