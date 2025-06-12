@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <h2 class="mb-3 text-center">Manajemen Project</h2>

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
                @if (session('error'))
                    <div class="alert alert-danger">
                        <strong>Gagal:</strong> {{ session('error') }}
                    </div>
                @endif

                <div class="mb-3">
                    <a class="btn btn-success" href="{{ route('project.create') }}">
                        <i class="bi bi-plus-circle me-2"></i>Tambah project
                    </a>
                
                    

                </div>

                @if ($projects->isEmpty())
                    <p class="text-center text-muted">Belum ada project yang ditambahkan.</p>
                @endif

               
                    <div class="card mb-4 shadow">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Project Belum Melewati Deadline</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @forelse ($projectsSebelumDeadline as $project)
                                    @include('project._card', ['project' => $project])
                                @empty
                                    <p class="text-muted">Tidak ada project sebelum deadline.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="card mb-4 shadow">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">Project Telat (Melewati Deadline)</h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @forelse ($projectsTelat as $project)
                                    @include('project._card', ['project' => $project])
                                @empty
                                    <p class="text-muted">Tidak ada project yang telat.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection