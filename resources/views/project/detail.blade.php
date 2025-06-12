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
                    <h5>Progress Tugas</h5>
                    <canvas id="tugasDonutChart" width="400" height="200"></canvas>

                </div>
            </div>
            
        </div>
    </div>
@endsection
@section('scripts')

<canvas id="testChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('testChart').getContext('2d');
new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ['Test 1', 'Test 2'],
        datasets: [{
            data: [3, 2],
            backgroundColor: ['blue', 'orange']
        }]
    }
});
</script>


@endsection