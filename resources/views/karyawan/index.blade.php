@extends('layouts.app')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12 d-flex justify-content-between align-items-center">
                    <h1 class="p-3"><b>Manajemen Karyawan</b></h1>
                   
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">home</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">

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

                    <!-- Form Search -->
                    <form action="{{ route('karyawan.index') }}" method="GET" class="mb-3">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control"
                                placeholder="Cari nama, email, atau departemen..." value="{{ request('search') }}">
                            <button class="btn btn-primary" type="submit">Cari</button>
                        </div>
                        @if(request()->anyFilled(['search', 'nama', 'email', 'departemen']))
                            <div class="col-12">
                                <a href="{{ route('karyawan.index') }}" class="btn btn-outline-danger">
                                    <i class="fas fa-times me-2"></i>Reset Pencarian
                                </a>
                            </div>
                        @endif
                    </form>
                    <div class="d-flex justify-content-between align-items-center mb-3">
                     
                    <a href="{{ route('departemen.index') }}" class="btn btn-info text-white mb-3">
                        <i class="fas fa-building me-2"></i>Kelola Departemen
                    </a>
                     <a href="{{ route('karyawan.create') }}" class="btn btn-success mb-3">
                        <i class="fas fa-plus me-2"></i>Tambah Karyawan
                    </a>

                    </div>

                    <table class="table table-bordered shadow">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Karyawan</th>
                                <th>Email</th>
                                <th>Departemen</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($karyawans as $karyawan)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $karyawan->nama_karyawan }}</td>
                                    <td>{{ $karyawan->email }}</td>
                                    <td>{{ $karyawan->departemen->nama_departemen }}</td>
                                    <td>
                                        <a href="{{ route('karyawan.edit', $karyawan->id)}}"
                                            class="btn bg-warning text-white btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST"
                                            class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn bg-danger text-white btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Data karyawan tidak ditemukan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center mt-3">
                        {{ $karyawans->onEachSide(1)->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection