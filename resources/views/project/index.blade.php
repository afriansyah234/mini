@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
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
                <h2 class="text-center">Manajemen Project</h2>
                <div class="text-center">
                    <a class="btn btn-success" href="{{ route('project.create') }}"><i
                            class="bi bi-plus-circle me-2"></i>Tambah project</a>
                </div>
                <table class="table table-bordered shadow mt-4">
                    <thead>
                        <tr>
                            <th>Nama Project</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Penanggung Jawab</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($projects as $project)
                            <tr>
                                <td>{{ $project->nama_project }}</td>
                                <td>{{ $project->deskripsi }}</td>
                                <td>
                                    @php
                                        $badge = [
                                            'perencanaan' => 'bg-secondary',
                                            'berjalan' => 'bg-warning',
                                            'ditunda' => 'bg-warning',
                                            'selesai' => 'bg-success'
                                        ][$project->status->status_project] ?? 'bg-secondary'
                                    @endphp
                                    <span class="badge {{ $badge }}">
                                        {{ ucfirst($project->status->status_project) }}
                                    </span>
                                </td>
                                <td>{{ $project->karyawan->nama_karyawan ?? '-'}}</td>
                                <td class="d-flex justify-content-center">
                                    <a class="btn btn-info me-2 text-white" href="{{ route('project.show', $project->id) }}"><i class="fas fa-eye"></i> </a>
                                    <form action="{{ route('project.destroy', $project->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
@endsection