@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Manajemen Tugas</h1>
                <a href="{{ route('tugas.create') }}" class="btn btn-secondary"><i class="fas fa-plus me-2"></i>tambah
                    tugas</a>
            </div>
            <form class="row g-3" action="{{ route('tugas.index') }}">
                <div class="col-auto">
                    <label for="" class="visually-hidden">search</label>
                    <input type="search" class="form-control" id="search" placeholder="search">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3">search</button>
                </div>
            </form>
            <table class="table table-bordered shadow mt-4">
                <thead class="text-center">
                    <tr>
                        <th>judul tugas</th>
                        <th>deskripsi</th>
                        <th>prioritas</th>
                        <th>status tugas</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($tugass->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data tugas</td>
                    </tr> @else
                        @foreach ($tugass as $tugas)
                            <tr>
                                <td>{{ $tugas->judul_tugas }}</td>
                                <td>{{ $tugas->deskripsi }}</td>
                                <td>{{ $tugas->prioritas }}</td>
                                <td>{{ $tugas->status->nama_status ?? 'Status Tidak Tersedia' }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection