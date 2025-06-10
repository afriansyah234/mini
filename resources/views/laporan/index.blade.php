@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h1>Manajemen laporan</h1>
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <strong>Terjadi kesalahan:</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        <strong>Gagal:</strong> {{ session('error') }}
                    </div>
                @endif
                <table class="table table-bordered shadow mt-4">
                    <!-- Table Headers -->
                    <thead>
                        <tr>
                            <th>No</th>
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
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $laporan->project->nama_project }}</td>
                                    <td>{{ Str::limit($laporan->deskripsi_laporan, 50) }}</td>
                                    <td>
                                        @php
                                            $status = strtolower($laporan->statuslaporan);
                                            $badgeClass = match ($status) {
                                                'sedang di cek' => 'bg-warning text-dark',
                                                'diterima' => 'bg-success',
                                                'ditolak' => 'bg-danger',
                                                default => 'bg-secondary'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeClass }}">
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
                                        <a href="{{ route('laporan.edit', $laporan->id) }}"
                                            class="btn bg-warning btn-sm text-white">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('laporan.destroy', $laporan->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn bg-danger btn-sm text-white"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus laporan ini?')">
                                                <i class="fas fa-trash"></i>
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
        </div>
    </div>
@endsection