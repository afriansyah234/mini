@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('karyawan.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-3">
                                <label for="Nama_karyawan" class="form-label">Nama karyawan</label>
                                <input type="text" class="form-control" id="Nama_karyawan" name="Nama_karyawan" required>
                                <div class="invalid-feedback">
                                    Nama karyawan karyawan harus diisi.
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                    <div class="invalid-feedback">
                                        Email harus diisi dengan format yang benar.
                                    </div>
                                    <div class="mb-3">
                                        <label for="departemen" class="form-label">departemen</label>
                                        <input type="text" class="form-control" id="departemen" name="departemen" required>
                                        <div class="invalid-feedback">
                                            departemen harus diisi.
                                        </div>
                                        <button type="submit" name="Submit" value="simpan" class="btn btn-primary">
                                            <i class="fas fa-save me-1 "></i> Simpan Data
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection