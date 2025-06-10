@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Project Kanban: {{ $project->nama_project }}</h1>

        @php
            // Definisikan warna untuk setiap status
            $statusColors = [
                'belum dimulai' => 'secondary',
                'dalam pengerjaan' => 'warning',
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
                                        <h6 class="card-title">{{ $tugas->judul_tugas }}</h6>
                                        <p class="small text-muted">{{ Str::limit($tugas->deskripsi, 60) }}</p>

                                        @if($tugas->karyawan)
                                            <p class="small mb-2">
                                                <i class="fas fa-user"></i> {{ $tugas->karyawan->nama_karyawan }}
                                            </p>
                                        @endif

                                        <form method="POST" action="{{ route('tugas.update-status', $tugas->id) }}">
                                            @csrf
                                            <select name="status_tugas_id" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                @foreach($statuses as $statusOpt)
                                                    <option value="{{ $statusOpt->id }}" {{ $tugas->status_tugas_id == $statusOpt->id ? 'selected' : '' }}>
                                                        {{ $statusOpt->nama_status }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
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