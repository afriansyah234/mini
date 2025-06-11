@extends('layouts.app')
@section('content')
    <div class="container">
        <h2 class="mb-4">Riwayat Tugas Selesai</h2>

        @if($tugas->isEmpty())
            <p class="text-muted">Belum ada tugas yang selesai.</p>
        @endif

        @foreach($tugas as $item)
            <div class="card mb-3">
                <div class="card-body">
                    <h5>{{ $item->judul_tugas }}</h5>
                    <p>{{ Str::limit($item->deskripsi, 100) }}</p>
                    <p><strong>Deadline:</strong> {{ optional($item->deadline)->tanggal ?? '-' }}</p>
                    <p><strong>Karyawan:</strong> {{ $item->karyawan->nama_karyawan ?? '-' }}</p>
                </div>
            </div>
        @endforeach
    </div>
@endsection