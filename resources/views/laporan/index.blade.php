@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Manajemen laporan</h1>
                 <a href="{{ route('laporan.create') }}" class="btn btn-secondary">
                        <i class="fas fa-plus me-2"></i>Buat Laporan Baru
                    </a>


                <!-- Task Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <!-- Table Headers -->
                                <thead>
                                    <tr>
                                        <th>Nama Project</th>
                                        <th>Deskripsi</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Lampiran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <!-- Table Body -->
                                <tbody>
                                    @if($laporans->count() > 0)
                                        @foreach($laporans as $laporan)
                                            <tr>
                                                <td>{{ $laporan->project->nama_project }}</td>
                                                <td>{{ Str::limit($laporan->deskripsi_laporan, 50) }}</td>
                                                <td>
                                                    @php
                                                    $badgeColors = [
                                                        'sedang di cek' => 'bg-warning',
                                                        'diterima' => 'bg-success',
                                                        'ditolak' => 'bg-danger',
                                                    ];
                                                    $warna = $badgeColors[strtolower($laporan->statuslaporan)] ?? 'secondary';
                                                    @endphp
                                                    <span class="badge bg-{{ $warna }}">
                                                        {{ ucfirst($laporan->statuslaporan) }}
                                                    </span>
                                                </td>
                                                <td>{{ $laporan->created_at->format('d/m/Y H:i') }}</td>
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
                                                    <a href="{{ route('laporan.show', $laporan->id) }}" class="btn btn-info btn-sm">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                    <a href="{{ route('laporan.edit', $laporan->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="fas fa-edit"></i> Edit
                                                    </a>
                                                    <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data laporan</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection