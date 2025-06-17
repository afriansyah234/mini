@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card mt-2 shadow-lg">
        <div class="card-header">
            <div class="d-flex justify-content-between mb-3">
                                <h4 class="mb-0"><i class="fas fa-building me-2"></i>Daftar Departemen</h4>
                                <a href="{{ route('departemen.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus me-2"></i>Tambah Departemen
                                    </a>
                            </div>
                                    <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left"></i>Kembali
                                    </a>
        </div>
        <div class="card-body">
            <table class="table table-striped table-hover text-center">
                 <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Departemen</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($departemens as $departemen)
                    <tr>
                    <td>{{ $loop->iteration}}</td>
                    <td>{{ $departemen->nama_departemen }}</td>
                    <td>
                        <a href="{{ route('departemen.edit',$departemen->id) }}">
                            <button type="submit" class="btn bg-warning text-white">
                                <i class="fas fa-edit"></i>
                            </button>
                        </a>
                        <form action="{{ route('departemen.destroy',$departemen->id) }}" method="post" class="d-inline">
                            @method('DELETE')
                            @csrf
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus departemen ini?')">
                                <i class="fas fa-trash-alt text-white"></i>
                            </button>
                        </form>
                    </td>
                    </tr>
                    @endforeach
                </tbody>
                
            </table>
               <div class="d-flex justify-content-center mt-2">
                {{ $departemens->onEachSide(1)->links('pagination::bootstrap-4') }}
               </div>
            </div>
        </div>
    </div>
</div>
@endsection
