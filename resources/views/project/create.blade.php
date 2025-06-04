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
        <div class="card shadow-lg">
            <div class="col-md-12">
                
                <h2 class="text-center">Tambahkan project</h2>
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
                        <div class="mb-3">
                            <label for="status_project" class="form-label">Status</label>
                            <select class="form-select @error('status_project') is-invalid @enderror" id="status_project"
                                name="status_project" required>
                                <option value="" disabled selected>Pilih Status</option>
                                @foreach($statuss as $status)
                                @if ($status->status_project == 'perencanaan')
                                <option value="{{ $status->id }}" {{ old('status_project') == $status->id ? 'selected' : '' }}>{{ $status->status_project }}</option>
                                @endif
                                    
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
                            <label for="" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" rows="5" required
                                placeholder="Masukkan deskripsi project"></textarea>
                                <div class="invalid-feedback">
                                    Masukkan deskripsi project
                                </div>
                        </div>
                        

                    </div>
                    <div class="mt-3 md-3 mb-3 ms-4 d-flex justify-content-between align-items-center">
                    <button href="{{ route('project.index') }}" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i>
                        </button>
                        <div class="mx-auto">
                            <button type="submit" class="btn btn-primary" class="text-center">
                            <i class="fas fa-save me-1"></i>
                        </button>
                        </div>
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