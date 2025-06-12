{{-- resources/views/project/history.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="container">
        <h2 class="mb-4">Riwayat Project (Selesai)</h2>

        @if($projects->isEmpty())
            <p class="text-muted">Belum ada project yang selesai.</p>
        @else
            <div class="row">
                @foreach ($projects as $project)
                    <div class="col-md-4 mb-3">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h5 class="card-title">{{ $project->nama_project }}</h5>
                                <p class="card-text">{{ $project->deskripsi }}</p>
                                <p class="text-muted mb-0">Deadline: {{ $project->deadline ?? '-' }}</p>
                                <a href="{{ route('project.history-detail', $project->id) }}"
                                    class="btn btn-primary btn-sm mt-2">Detail</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection