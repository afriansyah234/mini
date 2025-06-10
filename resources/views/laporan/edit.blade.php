@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-edit"></i>Edit Data Laporan</h4>
                </div>

                <div class="card-body shadow-lg">
                    <form action="{{ route('laporan.update',$laporan->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama Project -->
                        <div class="mb-3 col-md-12">
                                <label for="project_id" class="form-label">Pilih Project</label>
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
                            <textarea name="deskripsi_laporan" id="deskripsi_laporan" class="form-control" rows="4">{{ old('deskripsi_laporan',$laporan->deskripsi_laporan) }}</textarea>
                            @error('deskripsi_laporan')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Status Laporan -->
                        <div class="mb-3">
                            <label for="statuslaporan" class="form-label">Status Laporan</label>
                            @php
                                $statuses = ['sedang di cek', 'diterima', 'ditolak'];
                            @endphp

                            <select class="form-select @error('statuslaporan') is-invalid @enderror" id="statuslaporan" name="statuslaporan" required>
                                <option disabled selected>-- Pilih Status --</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status }}" {{ old('statuslaporan', $laporan->statuslaporan) == $status ? 'selected' : '' }}>
                                        {{ ucfirst($status) }}
                                    </option>
                                @endforeach
                            </select>

                                @error('statuslaporan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                        </div>

                        <!-- Upload Lampiran -->
                        <div class="mb-4">
                            <label for="lampiran" class="form-label">Lampiran File</label>
                            <input 
                                type="file" 
                                class="form-control" 
                                id="lampiran" 
                                name="lampiran[]" 
                                multiple
                                accept=".pdf,.jpg,.jpeg,.png,.doc,.docx,.xls,.xlsx"
                            >
                            <small class="text-muted">Format: PDF, JPG, PNG, DOC, XLS (Maks. 5MB/file)</small>
                            @error('lampiran.*')
                                <div class="text-danger mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        <div>
                        <input type="hidden" name="tanggal_laporan" value="{{ \Carbon\Carbon::now()->toDateString() }}">

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