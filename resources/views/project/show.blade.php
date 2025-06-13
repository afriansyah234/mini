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
            $statusColors = [
                'belum dimulai' => 'secondary',
                'dalam pengerjaan' => 'primary',
                'menunggu review' => 'info',
                'selesai' => 'success',
                'telat' => 'danger'
            ];

            $statusList = array_keys($statusColors);
        @endphp

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-5 g-4">
            @foreach($statusList as $status)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-header bg-{{ $statusColors[$status] }} text-white">
                            {{ ucfirst($status) }}
                            <span class="badge bg-light text-dark float-end">
                                @if($status === 'telat')
                                                    {{ $project->tugas->filter(function ($tugas) {
                                        return $tugas->deadline && $tugas->deadline->tanggal < now() && $tugas->status->nama_status !== 'selesai';
                                    })->count() }}
                                @else
                                                    {{ $project->tugas->filter(function ($tugas) use ($status) {
                                        $isLate = $tugas->deadline && $tugas->deadline->tanggal < now() && $tugas->status->nama_status !== 'selesai';
                                        return $tugas->status->nama_status === $status && !$isLate;
                                    })->count() }}
                                @endif
                            </span>
                        </div>

                        <div class="card-body">
                            @php
                                $tugasList = $status === 'telat'
                                    ? $project->tugas->filter(function ($tugas) {
                                        return $tugas->deadline && $tugas->deadline->tanggal < now() && $tugas->status->nama_status !== 'selesai';
                                    })
                                    : $project->tugas->filter(function ($tugas) use ($status) {
                                        $isLate = $tugas->deadline && $tugas->deadline->tanggal < now() && $tugas->status->nama_status !== 'selesai';
                                        return $tugas->status->nama_status === $status && !$isLate;
                                    });
                            @endphp

                            @foreach($tugasList as $tugas)
                                            <div class="card mb-3 shadow-sm">
                                                <div class="card-body">
                                                    <div class="mb-2">
                                                        <h6 class="card-title mb-1">{{ $tugas->judul_tugas }}</h6>

                                                        
                                                    </div>
                                                    <div class="mb-2">
                                                    <p class="small ms-1">Deskripsi: {{ Str::limit($tugas->deskripsi, 60) }}</p>
                                                    </div>
                                                    @if($tugas->karyawan)
                                                        <p class="small mb-2">Yang bertugas: {{ $tugas->karyawan->nama_karyawan }}</p>
                                                    @endif

                                                    @if($tugas->kategoriTugas)
                                                        <p class="small mb-1">Kategori:{{ $tugas->kategoriTugas->nama_kategori }}</p>
                                                    @endif


                                                    <div class="mb-2">
                                                        <span class="text-muted">Deadline:
                                                            {{ \Carbon\Carbon::parse($tugas->deadline->tanggal)->translatedFormat('d F Y') }}</span>
                                                    </div>

                                                    <span class="badge {{ [
                                    'rendah' => 'bg-secondary',
                                    'sedang' => 'bg-warning',
                                    'tinggi' => 'bg-warning',
                                    'krisis' => 'bg-danger'
                                ][$tugas->prioritas] ?? 'bg-secondary' }}">
                                                        {{ ucfirst($tugas->prioritas) }}
                                                    </span>

                                                    <form method="POST" action="{{ route('tugas.update-status', $tugas->id) }}" class="mt-2">
                                                        @csrf
                                                        <select name="status_tugas_id" class="form-select form-select-sm"
                                                            onchange="this.form.submit()">
                                                            @foreach($statuses as $statusOpt)
                                                                <option value="{{ $statusOpt->id }}" {{ $tugas->status_tugas_id == $statusOpt->id ? 'selected' : '' }}>{{ $statusOpt->nama_status }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </form>

                                                    <div class="d-flex gap-2 mt-2">
                                                        <a href="{{ route('tugas.edit', $tugas->id) }}"
                                                            class="btn btn-sm btn-warning text-white">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('tugas.destroy', $tugas->id) }}" method="POST"
                                                            class="d-inline-block">
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