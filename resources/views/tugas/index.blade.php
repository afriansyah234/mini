@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
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
                    <h1>Manajemen Tugas</h1>
                    <a href="{{ route('tugas.create') }}" class="btn btn-secondary">
                        <i class="fas fa-plus me-2"></i>Tambah Tugas
                    </a>
                </div>


                <form action="{{ route('tugas.index') }}" method="GET" class="row g-3 mb-4">
                    <div class="col-md-10">
                        <input type="search" name="search" class="form-control"
                            placeholder="Cari berdasarkan judul, deskripsi, project atau status..."
                            value="{{ request('search') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-search me-2"></i>Cari
                        </button>
                    </div>
                    @if(request()->anyFilled(['search', 'prioritas', 'project_id']))
                        <div class="col-12">
                            <a href="{{ route('tugas.index') }}" class="btn btn-outline-danger">
                                <i class="fas fa-times me-2"></i>Reset Pencarian
                            </a>
                        </div>
                    @endif
                </form>

                <!-- Task Table -->
                <div class="card shadow">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-center">
                                <thead class="table-light">
                                    <tr class="text-center">
                                        <th>Judul Tugas</th>
                                        <th>Project</th>
                                        <th>Deskripsi</th>
                                        <th>Prioritas</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($tugass as $tugas)
                                        <tr>
                                            <td>{{ $tugas->judul_tugas }}</td>
                                            <td>{{ $tugas->project->nama_project }}</td>
                                            <td>{{ $tugas->deskripsi }}</td>
                                            <td class="text-center">
                                                @php
                                                    $badgeClass = [
                                                        'rendah' => 'bg-success',
                                                        'sedang' => 'bg-warning',
                                                        'tinggi' => 'bg-danger',
                                                        'krisis' => 'bg-danger'
                                                    ][$tugas->prioritas] ?? 'bg-secondary';
                                                @endphp
                                                <span class="badge {{ $badgeClass }}">
                                                    {{ ucfirst($tugas->prioritas) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                @php
                                                    $badge = [
                                                        'belum dimulai' => 'bg-secondary',
                                                        'dalam pengerjaan' => 'bg-warning',
                                                        'menunggu review' => 'bg-warning',
                                                        'selesai' => 'bg-success'
                                                    ][$tugas->status->nama_status] ?? 'bg-secondary'
                                                @endphp
                                                <span class="badge {{ $badge }}">
                                                    {{ ucfirst($tugas->status->nama_status) }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ route('tugas.edit', $tugas->id) }}"
                                                        class="btn btn-sm btn-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('tugas.destroy', $tugas->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger" title="Hapus"
                                                            onclick="return confirm('Apakah Anda yakin?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6" class="text-center py-4">Tidak ada data tugas ditemukan</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                @if($tugass->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        {{ $tugass->appends(request()->query())->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection