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
        <div class="card">
            <div class="col-md-12">
                <div class="ms-4 mt-4">
                    <a href="{{ route('project.index') }}" class="btn btn-secondary"><i class="bi bi-arrow-left"></i>
                        Kembali</a>
                </div>
                <h2 class="text-center">Tambahkan project</h2>
                <form action="{{ route('project.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row g-3 need-validation">
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
                            <select name="karyawan_id" id="karyawan_id" class="form-control" required>
                                <option disabled selected>-- Pilih Karyawan --</option>
                                @foreach ($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id}}">{{ $karyawan->nama_karyawan }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback">
                                Pilih penanggungjawab project
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="5" required
                                placeholder="Masukkan deskripsi project"></textarea>
                                <div class="invalid-feedback">
                                    Masukkan deskripsi project
                                </div>
                        </div>
                        <div class="mb-3">
                            <label for="status_project" class="form-label">Status</label>
                            <select class="form-select @error('status_project') is-invalid @enderror" id="status_project"
                                name="status_project" required>
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

                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-secondary">Simpan project</button>
                    </div>
                </form>
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