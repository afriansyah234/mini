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
        $departemens = Departemen::paginate(5); 
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
        $validated = $request->validate([
            'nama_departemen'=> 'required|string',
        ]);
        $validated['nama_departemen']= strtoupper($validated['nama_departemen']);
        Departemen::create($validated);
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
        $departemen = Departemen::findOrFail($id);
        $departemen->edit();
        return view('departemen.edit',compact('departemen'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        $validated = $request->validate(['nama_departemen'=> 'required|string']);
        $validated['nama_departemen'] = strtoupper($validated['nama_departemen']);
        $departemen = Departemen::findOrFail($id);
        $departemen->update($validated);
        return redirect()->route("departemen.index")->with('success','Departemen Berhasil di update');
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
