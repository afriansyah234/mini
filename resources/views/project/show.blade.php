@extends('layouts.app')
@section('content')
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h2>Detail Project</h2>
                                <p>Nama Project : {{ $project->nama_project }}</p>
                                <p>Deskripsi : {{ $project->deskripsi }}</p>
                                <p>Status : {{ $project->status_project }}</p>
                                <p>Penanggung Jawab : {{  $project->karyawan->nama_karyawan }}</p>
                                <div>
                                    <a href="{{ route('project.index') }}" class="btn btn-secondary">Back</a>
                                    <a href="{{ route('project.edit',$project->id) }}" class="btn btn-warning">Edit Project</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection