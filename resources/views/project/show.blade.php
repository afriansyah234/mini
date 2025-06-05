@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-4 shadow">
            <div class="card-header">
                <h1>{{ $project->nama_project }}</h1>
            </div>
            <div class="card-body">
                <h5 class="card-title">Deskripsi Project</h5>
                <p class="card-text">{{ $project->deskripsi }}</p>
            </div>
        </div>

        <!-- Daftar Tugas dalam Card -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Daftar Tugas</h3>
        </div>

        @if($project->tugas->count() > 0)
            <div class="row">
                <!-- Card Add Tugas -->
                <div class="col-md-4 mb-4">
                    <a href="{{ route('tugas.create', ['project_id' => $project->id]) }}"
                        class="card h-90 shadow-lg d-flex align-items-center justify-content-center text-decoration-none"
                        style="min-height: 200px; border: 2px dashed #ccc; background-color: #f8f9fa;">
                        <div class="text-center p-4">
                            <i class="fas fa-plus-circle fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tambah Tugas Baru</h5>
                        </div>
                    </a>
                </div>

                @foreach($project->tugas as $tugas)
                    <div class="col-md-4 mb-4">
                        <div class="card h-90 shadow-lg">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-start">
                                    <h5 class="card-title">{{ $tugas->judul_tugas }}</h5>
                                    <span
                                        class="badge @if($tugas->status->nama_status == 'selesai') bg-success @elseif($tugas->status->nama_status == 'dalam pengerjaan') bg-warning @else bg-secondary @endif">
                                        {{ $tugas->status->nama_status }}
                                    </span>
                                </div>
                            </div>
                            <div class="card-body pb-0"> <!-- pb-0 untuk menghilangkan padding bottom -->
                                <p class="card-text text-muted">{{ $tugas->deskripsi }}</p>
                            </div>

                            <!-- Card Footer tanpa border -->
                            <div class="card-footer bg-transparent border-0 pt-0 d-flex justify-content-end gap-2">
                                <span class="badge bg-{{ $tugas->deadline->tanggal < now() ? 'danger' : 'success' }}">
                                    Deadline: {{ $tugas->deadline->tanggal->format('d M Y') }}
                                </span>
                                <a href="{{ route('tugas.edit', $tugas->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-pencil"></i>
                                </a>
                                <form action="{{ route('tugas.destroy', $tugas->id) }}" method="post"
                                    onsubmit="return confirm('yakin ingin menghapus ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row">
                <!-- Card Add Tugas -->
                <div class="col-md-4 mb-4">
                    <a href="{{ route('tugas.create', ['project_id' => $project->id]) }}"
                        class="card h-90 shadow-lg d-flex align-items-center justify-content-center text-decoration-none"
                        style="min-height: 200px; border: 2px dashed #ccc; background-color: #f8f9fa;">
                        <div class="text-center p-4">
                            <i class="fas fa-plus-circle fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Tambah Tugas Baru</h5>
                        </div>
                    </a>
                </div>

                <!-- Empty State -->
                <div class="col-md-8">
                    <div class="card h-100 d-flex align-items-center justify-content-center" style="min-height: 200px;">
                        <div class="card-body text-center py-5">
                            <i class="bi bi-clipboard-x fs-1 text-muted"></i>
                            <p class="mt-3 mb-0">Belum ada tugas untuk project ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
@endsection