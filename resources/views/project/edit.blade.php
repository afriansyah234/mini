@extends('layouts.app')
@section('content')
    <!-- Tagify CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css">
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
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Project</h4>
                    </div>
                    <div class="card-body shadow-lg">
                        <form action="{{ route('project.update', $project->id) }}" method="POST" class="needs-validation"
                            novalidate>
                            @csrf
                            @method('PUT')
                            <div class="row g-3 need-validation ms-3 mx-3">
                                <div class="col-md-6">
                                    <label for="" class="form-label">Nama Project</label>
                                    <input type="text" name="nama_project" min="1" class="form-control"
                                        value="{{ old('nama_project', $project->nama_project) }}"
                                        placeholder="Masukkan nama Project" required>
                                    <div class="invalid-feedback">
                                        Pilih nama project
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Pilih Penanggungjawab</label>
                                    <select name="karyawan_id" id="karyawan_id" class="form-control" required>
                                        <option disabled>-- Pilih Karyawan --</option>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id }}" {{ $project->karyawan_id == $karyawan->id ? 'selected' : '' }}>{{ $karyawan->nama_karyawan }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Pilih penanggungjawab project
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="anggota_id">Pilih Anggota</label>
                                    <select name="anggota_id[]" id="anggota_id" class="form-select select2" multiple
                                        required>
                                        <option disabled>-- Pilih Anggota --</option>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id }}" {{ in_array($karyawan->id, $project->anggota->pluck('id')->toArray()) ? 'selected' : '' }}>
                                                {{ $karyawan->nama_karyawan }} - {{ $karyawan->departemen->nama_departemen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Pilih anggota project
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="status_project" class="form-label">Status</label>
                                    <select class="form-select @error('status_project') is-invalid @enderror"
                                        id="status_project" name="status_project" required>
                                        <option value="" disabled>Pilih Status</option>
                                        @foreach($statuss as $status)
                                            <option value="{{ $status->id }}" {{ old('status_project', $project->status_project) == $status->id ? 'selected' : '' }}>
                                                {{ $status->status_project }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_project')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="invalid-feedback">
                                        Pilih status project
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label for="deadline" class="form-label">Deadline Project</label>
                                    <input type="date" name="deadline" class="form-control"
                                        min="{{ now()->toDateString() }}" value="{{ old('deadline', $project->deadline) }}"
                                        required>
                                </div>
                                <div class="col-md-12">
                                    <label for="kategori_tugas" class="form-label">Kategori Tugas</label>
                                    <input type="text" name="kategori_tugas" id="kategori_tugas" class="form-control"
                                        value='@json($kategoriTugasJson)'>
                                </div>
                                <div class="col-md-12">
                                    <label for="" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="5"
                                        required>{{ old('deskripsi', $project->deskripsi) }}</textarea>
                                    <div class="invalid-feedback">
                                        Masukkan deskripsi project
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <a href="{{ route('project.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i> Perbarui
                                </button>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script>
        $(document).ready(function () {
            $('#anggota_id').select2({
                placeholder: "-- Pilih Anggota --",
                allowClear: true,
                width: '100%'
            });
            $('form').on('submit', function () {
                const selected = $('#anggota_id').val();
                if (!selected || selected.length === 0) {
                    $('#anggota_id').addClass('is-invalid');
                    return false;
                } else {
                    $('#anggota_id').removeClass('is-invalid');
                }
            });
        });
    </script>

    <script>
        (() => {
            'use strict'
            const forms = document.querySelectorAll('.needs-validation')
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
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script>
        new Tagify(document.querySelector('#kategori_tugas'));
    </script>
@endsection