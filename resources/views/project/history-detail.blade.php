@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Detail Riwayat Project: {{ $project->nama_project }}</h3>
        <p><strong>Deskripsi:</strong> {{ $project->deskripsi }}</p>
        <p><strong>Deadline:</strong> {{ $project->deadline }}</p>
        <p><strong>Status:</strong> {{ $project->status->nama_status }}</p>

        <hr>
        <h4>Riwayat Tugas</h4>

        @if ($tugas->isEmpty())
            <p class="text-muted">Tidak ada tugas pada project ini.</p>
        @else
            <ul class="list-group">
                @foreach ($tugas as $item)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div>
                            <strong>{{ $item->judul }}</strong><br>
                            <small>Deadline: {{ $item->deadline->tanggal ?? '-' }}</small>
                        </div>
                        <span class="badge bg-info">{{ $item->status->nama_status }}</span>
                    </li>
                @endforeach
            </ul>
        @endif

        <a href="{{ route('project.history') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
@endsection