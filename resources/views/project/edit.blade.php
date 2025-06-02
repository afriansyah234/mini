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
                    <a href="{{ route('project.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <h2 class="text-center my-4">Edit Project</h2>

                <form action="{{ route('project.update', $project->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row g-3 px-4">
                        <div class="col-md-12">
                            <label for="nama_project" class="form-label">Nama Project</label>
                            <input type="text" name="nama_project"
                                class="form-control @error('nama_project') is-invalid @enderror"
                                placeholder="Masukkan nama Project" required
                                value="{{ old('nama_project', $project->nama_project) }}">
                            @error('nama_project')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                rows="5" required
                                placeholder="Masukkan deskripsi project">{{ old('deskripsi', $project->deskripsi) }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="karyawan_id" class="form-label">Penanggung Jawab</label>
                            <select name="karyawan_id" id="karyawan_id"
                                class="form-control @error('karyawan_id') is-invalid @enderror" required>
                                <option value="" disabled>-- Pilih Karyawan --</option>
                                @foreach ($karyawans as $karyawan)
                                    <option value="{{ $karyawan->id }}" {{ old('karyawan_id', $project->karyawan_id) == $karyawan->id ? 'selected' : '' }}>
                                        {{ $karyawan->nama_karyawan }}
                                    </option>
                                @endforeach
                            </select>
                            @error('karyawan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label for="status_project" class="form-label">Status</label>
                            <select name="status_project" id="status_project"
                                class="form-control @error('status_project') is-invalid @enderror" required>
                                <option value="" disabled>-- Pilih Status --</option>
                                @foreach($statusProjects as $status)
                                    <option value="{{ $status->id }}" {{ old('status_project', $project->status_project) == $status->id ? 'selected' : '' }}>
                                        {{ $status->status_project }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_project')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 text-center my-4">
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="bi bi-save"></i> Simpan Perubahan
                            </button>
                        </div>
                    </div>
                </form>
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
            </div>
        </div>
    </div>
@endsection