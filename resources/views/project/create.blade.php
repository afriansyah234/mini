@extends('layouts.app')
@section('content')
<div class="container">
    <div class="card">
        <div class="col-md-12">
            <div class="ms-4 mt-4">
                <a href="{{ route('project.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Kembali</a>
            </div>
            <h2 class="text-center">Tambahkan project</h2>
            <form action="{{ route('project.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                  <div class="col-md-12">
                    <label for="" class="form-label">Nama Project</label>
                    <input type="text" name="nama_project" min="1" class="form-control" placeholder="Masukkan nama Project" required>
                </div>
                <div class="col-md-12">
                    <label for="" class="form-label">Deskripsi</label>
                    <textarea type="text" name="deskripsi" min="1" class="form-control" required>
                    </textarea>
                </div>
                  <div class="col-md-12">
                    <label for="" class="form-label">Pilih Penanggungjawab</label>
                    <select name="karyawan_id" id="karyawan_id" class="form-control" required>
                        <option disabled value="">-- Pilih Karyawan --</option>
                        @foreach ($karyawans as $karyawan)
                        <option value="{{ $karyawan->id}}">{{ $karyawan->nama_karyawan }}</option>
                        @endforeach
                    </select>
                </div> 
               
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-secondary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection