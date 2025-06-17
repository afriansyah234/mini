@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mt-2">
        <div class="card-header  bg-primary text-white">
            <h4 class="mb-0">
                <i class="fas fa-tasks me-2"></i> Detail Project: {{ $project->nama_project }}
            </h4>
        </div>

        <div class="card-body">
            <div class="mb-3">
                <a href="{{ route('project.index') }}" class="btn btn-secondary mb-3">
                    <i class="fas fa-arrow-left me-2"></i> Kembali
                </a>
            </div>

            <div style="display: flex; gap: 1%;">
                <!-- Kolom Kiri -->
                <div style="flex: 1;">
                    <p><strong>Deskripsi:</strong> {{ $project->deskripsi }}</p>
                    <p><strong>Status:</strong> {{ $project->status->status_project }}</p>
                    <p><strong>Deadline:</strong> {{ $project->deadline }}</p>
                    <hr>

                    <h5><strong>Penanggung Jawab</strong></h5>
                    <p>{{ $penanggungjawab->nama_karyawan }} – {{ $penanggungjawab->departemen->nama_departemen }}</p>
                    <hr>

                    <h5><strong>Anggota yang Terlibat</strong></h5> 
                    <ul>
                        @if($anggota->isNotEmpty())
                            @foreach ($anggota as $a)
                                <li>{{ $a->nama_karyawan }} – {{ $a->departemen->nama_departemen }}</li>
                            @endforeach
                        @else
                            <li>Tidak ada anggota yang terlibat dalam project ini.</li>
                        @endif
                    </ul>
                    <hr>
                </div>

                <!-- Kolom Kanan -->
                <div style="flex: 1;" class="card">
                    <div class="card-header  text-white text-center" style="background-color: #88CCF1;">
                        <h5 class="mb-0"><i class="fas fa-chart-pie me-2"></i> Statistik Tugas</h5>
                        
                    </div> 
                        <div class="card-body d-flex flex-column align-items-center justify-content-center gap-3">
                         @php
                        $total = $tugasselesai + $tugasbelumselesai ?: 1;
                        $persenSelesai = ($tugasselesai / $total) * 100;
                        $persenBelum = 100 - $persenSelesai;
                    @endphp
                    <input type="text"
                        class="knob"
                        value="{{ round($persenSelesai, 1) }}">

                    <div style="display: flex; flex-direction: column; gap: 10px; align-items: flex-start;">
                        <div style="display: flex; align-items: center;">
                            <span><strong>  Jumlah Tugas:</strong> {{ $totaltugas }}</span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <span style="display: inline-block; width: 16px; height: 16px; background-color: #4ade80; margin-right: 8px; border-radius: 3px;"></span>
                            <span><strong>Tugas Selesai:</strong> {{ $tugasselesai }}  </span>
                        </div>
                        <div style="display: flex; align-items: center;">
                            <span style="display: inline-block; width: 16px; height: 16px; background-color: #f87171; margin-right: 8px; border-radius: 3px;"></span>
                            <span><strong>Tugas Belum Selesai:</strong> {{ $tugasbelumselesai }}  </span>
                        </div>
                    </div>
                        </div>
                </div>
            </div>

            <div class="mt-3">
                <a class="btn btn-info" href="{{ route('project.show', $project->id) }}">
                    <i class="fas fa-info-circle"></i> Detail Tugas
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    $(function () {
        $(".knob").knob({
            'min': 0,
            'max': 100,
            'readOnly': true,
            'width': 120,
            'height': 120,
            'fgColor': "#4ade80",
            'bgColor': "#f87171",
            'thickness': 0.3,
            'angleOffset': -90,
            'angleArc': 360,
            'displayInput': true,
            'inputColor': '#333',
            format: function (value) {
                return value + '%';
            }
        });
    });
</script>
@endsection
