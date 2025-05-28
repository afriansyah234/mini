@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
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
                            <th> Status</th>
                            <th>Penanggung Jawab</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            @foreach ($projects as $project)
                                <td>{{ $project->nama_project }}</td>
                                <td>{{ $project->deskripsi }}</td>
                                <td>{{ $project->status_project }}</td>
                                <td>{{ $karyawans->Nama_karyawan }}</td>
                                <td>

                                </td>
                            @endforeach

                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection