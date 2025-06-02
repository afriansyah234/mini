@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('karyawan.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="row g-3">
                            <!-- Nama Karyawan -->
                            <div class="col-md-6">
                                <label for="nama_karyawan" class="form-label">Nama Karyawan</label>
                                <input type="text" class="form-control" id="nama_karyawan" name="nama_karyawan" required>
                                <div class="invalid-feedback">
                                    Nama karyawan harus diisi.
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                                <div class="invalid-feedback">
                                    Email harus diisi dengan format yang benar.
                                </div>
                            </div>

                            <!-- Departemen -->
                            <div class="col-12">
                                <label for="departemen" class="form-label">Departemen</label>
                                <input type="text" class="form-control" id="departemen" name="departemen" required>
                                <div class="invalid-feedback">
                                    Departemen harus diisi.
                                </div>
                            </div>

                            <!-- Tombol Submit -->
                            <div class="col-12 mt-4">
                                <button type="submit" name="Submit" value="simpan" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan Data
                                </button>
                            </div>
                        </div>
                    </form>

                    <script>
                        (() => {
                            'use strict';
                            const forms = document.querySelectorAll('.needs-validation');
                            Array.from(forms).forEach(form => {
                                form.addEventListener('submit', event => {
                                    if (!form.checkValidity()) {
                                        event.preventDefault();
                                        event.stopPropagation();
                                    }
                                    form.classList.add('was-validated');
                                }, false);
                            });
                        })();
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
