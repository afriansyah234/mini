@extends('layouts.app')
@section('content')
    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-edit"></i>Edit Data Karyawan</h4>
                    </div>
                    <div class="card-body shadow-lg">
                        <form action="{{ route('karyawan.update', $karyawans->id) }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row g-3">
                                <!-- Nama Karyawan -->
                                <div class="col-md-6">
                                    <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                    <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" required
                                        value="{{ $karyawans->nama_karyawan }}">
                                    <div class="invalid-feedback">
                                        Nama karyawan harus diisi.
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required
                                        value="{{ $karyawans->email }}">
                                    <div class="invalid-feedback">
                                        Email harus diisi dengan format yang benar.
                                    </div>
                                </div>

                                <!-- Departemen -->
                                <div class="col-12">
                                    <label for="departemen" class="form-label">Departemen</label>
                                    <input type="text" class="form-control" id="departemen" name="departemen" required
                                        value="{{ $karyawans->departemen->nama_departemen }}">
                                    <div class="invalid-feedback">
                                        Departemen harus diisi.
                                    </div>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <a href="{{ route('tugas.index') }}" class="btn btn-secondary me-md-2">
                                        <i class="fas fa-arrow-left me-1"></i> Kembali
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i> Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        (() => {
            'use strict'
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            const forms = document.querySelectorAll('.needs-validation')
            // Loop over them and prevent submission
            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()
    </script>
@endsection