@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Manajemen Karyawan</h1>
                <a href="{{ route('karyawan.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>
                    tambah karyawan</a>
                <div class="row rows-cols-1 rows-cols-md-2 rows-cols-lg-3 g-4 mt-4">
                    <div class="col">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">
                                    <table class="table table-bordered mt-3">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Nama Karyawan</th>
                                                <th>email</th>
                                                <th>department</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($karyawans as $karyawan)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $karyawan->Nama_karyawan }}</td>
                                                    <td>{{ $karyawan->email }}</td>
                                                    <td>{{ $karyawan->departemen }}</td>
                                                    <td>
                                                        <a href="{{ route('karyawan.edit', $karyawan->id)}}"
                                                            class="btn btn-warning btn-sm"><i class="fas fa-edit"></i>edit</a>
                                                        <form action="{{ route('karyawan.destroy', $karyawan->id) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm"><i
                                                                    class="fas fa-trash"></i>hapus</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection