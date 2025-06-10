@extends('layouts.app')
@section('content')
    <div class="container">
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

                <h1>Manajemen Karyawan</h1>

                <!-- Form Search -->
                <form action="{{ route('karyawan.index') }}" method="GET" class="mb-3">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama, email, atau departemen..." value="{{ request('search') }}">
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

                <a href="{{ route('karyawan.create') }}" class="btn btn-success mb-3">
                    <i class="fas fa-plus me-2"></i>Tambah Karyawan
                </a>

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
                                    <a href="{{ route('karyawan.edit', $karyawan->id)}}" class="btn bg-warning text-white btn-sm">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('karyawan.destroy', $karyawan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn bg-danger text-white btn-sm">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center">Data karyawan tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
