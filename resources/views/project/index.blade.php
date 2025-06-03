@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <h2 class="text-center mb-4">Manajemen Project</h2>

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

            <div class="mb-4 text-center">
                <a class="btn btn-success" href="{{ route('project.create') }}">
                    <i class="bi bi-plus-circle me-2"></i>Tambah project
                </a>
                 <!-- <a class="btn btn-success" href="{{ route('project.create') }}">
                    <i class="bi bi-card-list me-2"></i></i>Cek Project
                </a> -->
                
            </div>

            @if ($projects->isEmpty())
                <p class="text-center text-muted">Belum ada project yang ditambahkan.</p>
            @endif

            <div class="row">
                     @foreach ($projects as $project)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 shadow-lg">
                            <div class="card-header">
                               <div class="card-header d-flex justify-content-between align-items-center py-2">
    <h6 class="mb-0 fw-semibold">{{ $project->nama_project }}</h6>
    <div class="d-flex gap-1">
        <a class="btn btn-info btn-sm text-white" href="{{ route('project.show', $project->id) }}">
            <i class="fas fa-eye fa-sm"></i>
        </a>
        <form action="{{ route('project.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus project ini?')">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger btn-sm">
                <i class="fas fa-trash fa-sm"></i>
            </button>
        </form>
    </div>
</div>

                                    
                            </div>
                            <div class="card-body d-flex flex-column">
                                <p class="card-text"><strong>Deskripsi :</strong> {{ $project->deskripsi }}</p>
                                <p><strong>Status : </strong> 
                                    @php
                                        $badge = [
                                            'perencanaan' => 'bg-secondary',
                                            'berjalan' => 'bg-warning',
                                            'ditunda' => 'bg-warning',
                                            'selesai' => 'bg-success'
                                        ][$project->status->status_project] ?? 'bg-secondary'
                                    @endphp
                                    <span class="badge {{ $badge }}">{{ ucfirst($project->status->status_project) }}</span>
                                </p>
                                <p><strong>Penanggung jawab:</strong> {{ $project->karyawan->nama_karyawan ?? '-' }}</p>
                                
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        </div>
    </div>
</div>
@endsection
