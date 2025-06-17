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
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambahkan Project Baru</h4>
                    </div>
                    <div class="card-body shadow-lg">
                        <form action="{{ route('project.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf
                            <div class="row g-3 need-validation ms-3 mx-3">
                                <div class="col-md-6">
                                    <label for="" class="form-label">Nama Project</label>
                                    <input type="text" name="nama_project" min="1" class="form-control"
                                        placeholder="Masukkan nama Project" required>
                                    <div class="invalid-feedback">
                                        Pilih nama project
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="" class="form-label">Pilih Penanggungjawab</label>
                                    <select name="karyawan_id" id="karyawan_id" class="form-control"  required>
                                        <option disabled selected>-- Pilih Karyawan --</option>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id}}">{{ $karyawan->nama_karyawan }} - {{ $karyawan->departemen->nama_departemen }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Pilih penanggungjawab project
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                       <label for="anggota_id">Pilih Anggota</label>
                                    <select name="anggota_id[]" id="anggota_id" class="select2" data-placeholder="-- Pilih Anggota --" multiple="multiple" style="width: 100%   ;"
                                        required>
                                        @foreach ($karyawans as $karyawan)
                                            <option value="{{ $karyawan->id }}">{{ $karyawan->nama_karyawan }} -
                                                {{ $karyawan->departemen->nama_departemen }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Pilih anggota project
                                    </div> 
                                    </div>
                                    
                                </div>
                                <div class="mb-3">
                                    <label for="status_project" class="form-label">Status</label>
                                    <select class="form-select @error('status_project') is-invalid @enderror"
                                        id="status_project" name="status_project" required>
                                        <option value="" disabled selected>Pilih Status</option>
                                        @foreach($statuss as $status)
                                            <option value="{{ $status->id }}" {{ old('status_project') == $status->id ? 'selected' : '' }}>{{ $status->status_project }}</option>


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
                                        min="{{ now()->toDateString() }}" required>
                                </div>

                                <div class="col-md-12">
                                    <label for="kategori_tugas" class="form-label">Kategori Tugas</label>
                                    <input type="text" name="kategori_tugas" id="kategori_tugas" class="form-control"
                                        placeholder="Tambah kategori dan tekan enter">
                                </div>


                                <div class="col-md-12">
                                    <label for="" class="form-label">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" rows="5" required
                                        placeholder="Masukkan deskripsi project"></textarea>
                                    <div class="invalid-feedback">
                                        Masukkan deskripsi project
                                    </div>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-3">
                                <a href="{{ route('project.index') }}" class="btn btn-secondary me-md-2">
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
@endsection
@section('scripts')
    <!-- Bootstrap4 Duallistbox -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-duallistbox/4.0.2/jquery.bootstrap-duallistbox.min.js"></script>
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-duallistbox/4.0.2/bootstrap-duallistbox.min.css">
    <!-- Select2 CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
  $(function () {
    $('.select2').select2();
  });
</script>


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
    <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify"></script>
    <script>
        new Tagify(document.querySelector('#kategori_tugas'));
    </script>


@endsection