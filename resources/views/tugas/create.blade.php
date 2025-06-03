@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Tambah Tugas Baru</h4>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('tugas.store') }}" method="POST" class="needs-validation" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label for="project_id" class="form-label">Project</label>
                                <select class="form-select" id="project_id" name="project_id" required>
                                    <option value="" selected disabled>Pilih Project</option>
                                    @foreach($projects as $project)
                                        <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                            {{ $project->nama_project }}
                                        </option>
                                    @endforeach
                                </select>
                                    <div class="invalid-feedback">Pilih Project</div>
                            </div>

                            <div class="mb-3">
                                <label for="judul_tugas" class="form-label">Judul Tugas</label>
                                <input type="text" class="form-control @error('judul_tugas') is-invalid @enderror" 
                                       id="judul_tugas" name="judul_tugas" value="{{ old('judul_tugas') }}" required>
                               
                                    <div class="invalid-feedback">
                                        Masukkan judul tugas
                                    </div>
                                
                            </div>

                            <div class="mb-3">
                                <label for="deskripsi" class="form-label">Deskripsi</label>
                                <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                          id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                                    <div class="invalid-feedback">
                                        Masukkan deskripsi tugas
                                    </div>
                            </div>

                            <div class="mb-3">
                                <label for="prioritas" class="form-label">Prioritas</label>
                                <select class="form-select @error('prioritas') is-invalid @enderror" id="prioritas" name="prioritas" required>
                                    <option value="" disabled selected>Pilih Prioritas</option>
                                    <option value="rendah" {{ old('prioritas') == 'rendah' ? 'selected' : '' }}>Rendah</option>
                                    <option value="sedang" {{ old('prioritas') == 'sedang' ? 'selected' : '' }}>Sedang</option>
                                    <option value="tinggi" {{ old('prioritas') == 'tinggi' ? 'selected' : '' }}>Tinggi</option>
                                    <option value="krisis" {{ old('prioritas') == 'krisis' ? 'selected' : '' }}>krisis</option>

                                </select>
                                    <div class="invalid-feedback">
                                        Pilih prioritas tugas
                                    </div>
                            </div>

                            <div class="mb-3">
                                <label for="status_tugas_id" class="form-label">Status</label>
                                <select class="form-select @error('status_tugas_id') is-invalid @enderror" id="status_tugas_id" name="status_tugas_id" required>
                                    <option value="" disabled selected>Pilih Status</option>
                                    @foreach($statuses as $status)
                                        <option value="{{ $status->id }}" {{ old('status_tugas_id') == $status->id ? 'selected' : '' }}>
                                            {{ $status->nama_status }}
                                        </option>
                                    @endforeach
                                </select>
                                    <div class="invalid-feedback">
                                        Pilih status tugas
                                    </div>
                            </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('tugas.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Simpan
                                </button>
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