@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12"
            >@if (session('success'))
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
                <h1>Manajemen Karyawan</h1>
                <a href="{{ route('karyawan.create') }}" class="btn btn-primary"><i class="fas fa-plus me-2"></i>
                    tambah karyawan</a>
                     <table class="table table-bordered shadow mt-4">
                   <thead>
                                 <tr>
                                      <th>No</th>
                                                <th>Nama Karyawan</th>
                                                <th>email</th>
                                                <th>department</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>          
                                        <!-- table body -->
                                        <tbody>
                                            @foreach ($karyawans as $karyawan)
                                                <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $karyawan->nama_karyawan }}</td>
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
@endsection