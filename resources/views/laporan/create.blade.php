@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Buat Laporan</h3>
                    </div>
                     @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

                    <div class="card-body shadow-lg">
                        <form action="{{ route('laporan.store') }}" method="POST" enctype="multipart/form-data"
                            class="needs-validation" novalidate>
                            @csrf
                            <div class="mb-3 col-md-12">
                                <label for="project_id" class="form-label">Nama Project</label>
                              <input type="hidden" name="project_id" class="form-control"  value="{{ $project->id }}">
                              <input type="text"  class="form-control" value="{{ $project->nama_project }}" readonly>
                                <div class="invalid-feedback">
                                    Pilih nama project
                                </div>
                            </div>

                            <!-- Atas Nama -->
                            <div class="mb-3">
                                <label for="karyawan_id" class="form-label">Penanggung Jawab</label>
                                <input type="hidden" name="karyawan_id" class="form-control" value="{{ $project->karyawan_id }}">
                                <input type="text"  class="form-control" value="{{ $project->karyawan->nama_karyawan }}" readonly>

                                <div class="invalid-feedback">
                                    Pilih penanggung jawab laporan
                                </div>
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label for="deskripsi_laporan" class="form-label">Deskripsi Laporan</label>
                                <textarea name="deskripsi_laporan" id="deskripsi_laporan" class="form-control"
                                    rows="4">{{ old('deskripsi_laporan') }}</textarea>
                                <div class="invalid-feedback">
                                    Masukkan deskripsi laporan
                                </div>
                            </div>

                            <!-- Upload Lampiran -->
                            <div class="mb-4">
                                <label for="lampiran" class="form-label">Lampiran File</label>
                                <input type="file" class="form-control" id="lampiran" name="lampiran[]" multiple
                                    accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx">
                                <small class="text-muted">Format: PDF, JPG, PNG, DOC, XLS (Maks. 5MB/file)</small>
                                <div class="invalid-feedback">
                                    Pilih file lampiran (maks. 5MB/file)
                                </div>
                            </div>
                            <div>
                                <input type="hidden" name="tanggal_laporan"
                                    value="{{ \Carbon\Carbon::now()->toDateString() }}">

                            </div>


                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="{{ route('laporan.index') }}" class="btn btn-secondary me-md-2">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Simpan Laporan
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