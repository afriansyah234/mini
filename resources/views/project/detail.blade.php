@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-tasks me-2"></i>Detail Project: {{ $project->nama_project }}</h4>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <a href="{{ route('project.index') }}" class="btn btn-secondary mb-3">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
                <div>
                    <p><strong>Deskripsi : </strong> {{ $project->deskripsi }}</p>
                    <p><strong>Status : </strong> {{ $project->status->status_project }}</p>
                    <p><strong>Deadline : </strong> {{ $project->deadline }}</p>
                    <hr>
                    <h5><strong>Penanggung Jawab</strong> </h5>
                    <p>{{ $penanggungjawab->nama_karyawan }}--{{ $penanggungjawab->departemen->nama_departemen }}</p>
                    <hr>
                    <h5><strong>Anggota yang terlibat</strong></h5>
                    <ul>
                    @if($anggota->isNotEmpty())
                    @foreach ($anggota as $a)
                        <li>{{ $a->nama_karyawan }} - {{ $a->departemen->nama_departemen }}</li>
                    @endforeach
                    @else
                        <li>Tidak ada anggota yang terlibat dalam project ini.</li>
                    @endif
                    </ul>
                    <hr>
                    <div class="mt-5">
                        <h5>Status Tugas</h5>
                         <p>Selesai: {{ $tugasselesai }}, Belum: {{ $tugasbelumselesai }}, Total: {{ $totaltugas }}</p>
                         <input type="text" class="knob" value="30" data-width="120" data-height="120"
                           data-fgColor="#f56954">


                    </div>

                </div>
            </div>
            
        </div>
    </div>
@endsection
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@php
    $selesai = (int) $tugasselesai;
    $belum = (int) $tugasbelumselesai;
    $total = max(1, (int) $totaltugas);
@endphp

<script>
    const selesai = {{ $selesai }};
    const belum = {{ $belum }};
    const total = {{ $total }};
</script>


<script>
    $(function () {
        $(".knob").knob();
    });
</script>
@endsection