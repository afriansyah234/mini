@extends('layouts.app')
@section('content')
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h2>Detail Project</h2>
                                <p>Nama Project : {{ $laporan->project->nama_project }}</p>
                                <p>Deskripsi : {{ $laporan->deskripsi_laporan }}</p>
                                <p>Status : {{ $laporan->statuslaporan }}</p>
                                <p>Penanggung Jawab : {{  $laporan->karyawan->nama_karyawan }}</p>
                                <p>tanggal dibuat : {{ $laporan->created_at->format('d/m/Y H:i') }}</p>
                                <div>
                                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection