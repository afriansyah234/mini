@extends('layouts.app')
@section('content')
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <h2>Detail Project</h2>
                                <p>Nama Project : {{ $laporan->atas_nama }}</p>
                                <p>Deskripsi : {{ $laporan->deskripsi_laporan }}</p>
                                <p>Status : {{ $laporan->statuslaporan }}</p>
                                <p>Penanggung Jawab : {{  $laporan-> }}</p>
                                <div>
                                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">Back</a>
                                    <a href="{{ route('laporan.edit',$laporan->id) }}" class="btn btn-warning">Selesai</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
@endsection