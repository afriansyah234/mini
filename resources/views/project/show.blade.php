@extends('layouts.app')

@section('content')
  <section class="content-header">
    <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
      <h1>Kanban Board: {{ $project->nama_project }}</h1>
      </div>
      <div class="col-sm-6 d-none d-sm-block">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ route('project.index') }}">Home</a></li>
        <li class="breadcrumb-item active">{{ $project->nama_project }}</li>
      </ol>
      </div>
    </div>
    </div>
  </section>

  <section class="content pb-3">
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

    <div class="text-end">
    <a href="{{ route('tugas.create', ['project_id' => $project->id]) }}" class="btn btn-primary mb-3">
      <i class="fas fa-plus-circle"></i>
    </a>
    </div>

    <div class="container-fluid h-100">
    <div class="d-flex flex-nowrap" style="overflow-x:auto; gap: 1rem;">
      @foreach($statusList as $status)
      <div class="card card-row card-{{ $statusColors[$status] }}"
      style="min-width:340px; max-width:370px; flex:0 0 auto;">
      <div class="card-header {{ $status === 'menunggu review' ? 'bg-info' : '' }}">
      <h3 class="card-title">{{ $status }}</h3>
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

      @forelse($tugasList as $tugas)
      <div class="card card-{{ $statusColors[$status] === 'secondary' ? 'info' : 'primary' }} card-outline mb-3">
      <div class="card-header">
      <h5 class="card-title">{{ $tugas->nama_tugas }}</h5>
      <div class="card-tools">
      <a href="{{ route('tugas.edit', $tugas->id) }}" class="btn btn-tool">
        <i class="fas fa-pen"></i>
      </a>
      </div>
      </div>
      <div class="card-body">
      <p><strong>Penanggungjawab:</strong> {{ $tugas->karyawan->nama_karyawan ?? '-' }}</p>
      <p><strong>Deskripsi:</strong> {{ $tugas->deskripsi }}</p>
      <p><strong>Deadline:</strong>
      {{ $tugas->deadline ? $tugas->deadline->tanggal->format('d M Y') : 'Tidak ada' }}</p>
      <p><strong>yang mengerjakan:</strong>{{ $tugas->karyawan->1nama_karyawan }}</p>
      <span class="badge {{ [
      'rendah' => 'bg-secondary',
      'sedang' => 'bg-warning',
      'tinggi' => 'bg-warning',
      'krisis' => 'bg-danger'
      ][$tugas->prioritas] ?? 'bg-secondary' }}">
      {{ ucfirst($tugas->prioritas) }}
      </span>
      </div>
      </div>
      @empty
      <p class="text-center text-muted">Tidak ada tugas</p>
      @endforelse
      </div>
      </div>
    @endforeach
    </div>
    </div>
  </section>
@endsection