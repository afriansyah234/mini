@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6">Laporan Proyek & Tugas</h1>

    {{-- Bagian Project --}}
    <div class="mb-10">
        <h2 class="text-xl font-semibold mb-3"> Laporan Proyek</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 rounded-lg shadow">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border-b">Foto Bukti</th>
                        <th class="py-2 px-4 border-b">Tanggal</th>
                        <th class="py-2 px-4 border-b">Nama Pengguna</th>
                        <th class="py-2 px-4 border-b">Nama Project</th>
                        <th class="py-2 px-4 border-b">Deskripsi</th>
                        <th class="py-2 px-4 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($laporans as $laporan)
                        <tr class="hover:bg-gray-50">
                            <td class="py-2 px-4 border-b">{{ $laporan->foto_bukti }}</td>
                            <td class="py-2 px-4 border-b">{{ $laporan->tanggal_laporan }}</td>
                            <td class="py-2 px-4 border-b">{{ $laporan->atas_nama }}</td>
                            <td class="py-2 px-4 border-b">{{ $laporan->project->nama_project }}</td>
                            <td class="py-2 px-4 border-b">{{ $laporan->deskripsi_laporan }}</td>
                            <td class="py-2 px-4 border-b">{{ $laporan->statusLaporan->statuslaporan }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection