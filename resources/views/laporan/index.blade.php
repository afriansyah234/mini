@extends('layouts.app')

@section('content')
    <div class="container mx-auto p-4">
        <h1 class="text-2xl font-bold mb-6">Laporan Proyek & Tugas</h1>

        {{-- Bagian Project --}}
        <div class="mb-10">
            <h2 class="text-xl font-semibold mb-3"> Laporan Proyek</h2>
            <div class="overflow-x-auto">
                <table class="table table-bordered shadow">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 border-b">Nama Pengguna</th>
                            <th class="py-2 px-4 border-b">Nama Project</th>
                            <th class="py-2 px-4 border-b">Tanggal</th>
                            <th class="py-2 px-4 border-b">Status Laporan</th>
                            <th class="py-2 px-4 border-b">Deskripsi</th>
                            <th class="py-2 px-4 border-b">lampiran</th>
                            <th class="py-2 px-4 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporans as $laporan)
                            <tr class="hover:bg-gray-50">
                                <td class="py-2 px-4 border-b">{{ $laporan->karyawan->nama_karyawan }}</td>
                                <td class="py-2 px-4 border-b">{{ $laporan->project->nama_project }}</td>
                                <td>{{ $laporan->tanggal_laporan }}</td>
                                <td>{{ $laporan->statuslaporan }}</td>
                                <td class="py-2 px-4 border-b">{{ $laporan->deskripsi_laporan }}</td>
                                <td class="py-2 px-4 border-b">
                                    @if($laporan->lampiran)
                                        <a href="{{ asset('storage/' . $laporan->lampiran->path) }}" target="_blank">
                                            {{ $laporan->lampiran->nama_file }}
                                        </a>
                                    @else
                                        <span class="text-gray-500">Tidak ada lampiran</span>
                                    @endif
                                </td>
                                <td>
                                     <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-info">Detail</a>
                                    <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" class="inline-block">
                                       
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection