@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mb-3">
            <a href="{{ route('project.index') }}" class="btn btn-secondary mb-3">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
        <h1 class="my-4">Project : {{ $project->nama_project }}</h1>
        <div class="mb-3">
            <a href="{{ route('tugas.create') }}?project_id={{ $project->id }}" class="btn btn-success mb-3">
                <i class="fas fa-plus me-2"></i>Tambah Tugas
            </a>
        </div>

        @php
            // Definisikan warna untuk setiap status
            $statusColors = [
                'belum dimulai' => 'secondary',
                'dalam pengerjaan' => 'primary',
                'menunggu review' => 'info',
                'selesai' => 'success'
            ];

            // Daftar status yang akan ditampilkan
            $statusList = array_keys($statusColors);
        @endphp

        <div class="row">
            @foreach($statusList as $status)
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-{{ $statusColors[$status] }} text-white">
                            {{ ucfirst($status) }}
                            <span class="badge bg-light text-dark float-end">
                                {{ $project->tugas->where('status.nama_status', $status)->count() }}
                            </span>
                        </div>
                        <div class="card-body">
                            @foreach($project->tugas->where('status.nama_status', $status) as $tugas)
                                <div class="card mb-3 shadow-sm">
                                    <div class="card-body">
                                        <h6 class="card-title">Judul tugas : {{ $tugas->judul_tugas }}</h6>
                                        <p class="small text-muted">Deskripsi : {{ Str::limit($tugas->deskripsi, 60) }}</p>

                                        @if($tugas->karyawan)
                                            <p class="small mb-2">Yang bertugas : {{ $tugas->karyawan->nama_karyawan }}
                                            </p>
                                        @endif

                                        @foreach ($project->tugas as $tugas)
                                            @php
                                                $badge = [
                                                    'rendah' => 'bg-secondary',
                                                    'sedang' => 'bg-warning',
                                                    'tinggi' => 'bg-warning',
                                                    'krisis' => 'bg-success'
                                                ][$tugas->prioritas] ?? 'bg-secondary';
                                            @endphp
                                            <span class="badge {{ $badge }}">{{ ucfirst($tugas->prioritas) }}</span>
                                        @endforeach


                                        <form method="POST" action="{{ route('tugas.update-status', $tugas->id) }}">
                                            @csrf
                                            <select name="status_tugas_id" class="form-select form-select-sm mt-2"
                                                onchange="this.form.submit()">
                                                @foreach($statuses as $statusOpt)
                                                    <option value="{{ $statusOpt->id }}" {{ $tugas->status_tugas_id == $statusOpt->id ? 'selected' : '' }}>
                                                        {{ $statusOpt->nama_status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                        <div class="d-flex gap-1 mt-2">
                                            <a href="{{ route('tugas.edit', $tugas->id) }}"
                                                class="btn btn-sm btn-warning text-white mt-2">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('tugas.destroy', $tugas->id) }}" method="POST"
                                                class="d-inline-block mt-2">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus tugas ini?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection