@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card mt-5 mx-auto" style="width: 400px;">
        <div class="card-header text-center bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i><b>Tambah Departemen Baru</b></h5>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('departemen.store') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="nama_departemen" class="form-label">Nama Departemen</label>
                    <input type="text" class="form-control" id="nama_departemen" name="nama_departemen" required>
                    <div class="invalid-feedback">
                        Nama departemen harus diisi.
                    </div> 
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                    <a href="{{ route('departemen.index') }}" class="btn btn-secondary me-md-2">
                        <i class="fas fa-arrow-left me-1"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-1"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
