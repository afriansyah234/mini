@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Edit Project</h2>

        <form action="{{ route('project.update', $project->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="nama_project" class="form-label">Nama Project</label>
                <input type="text" name="nama_project" id="nama_project"
                    class="form-control @error('nama_project') is-invalid @enderror"
                    value="{{ old('nama_project', $project->nama_project) }}" required>
                @error('nama_project') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                    rows="3">{{ old('deskripsi', $project->deskripsi) }}</textarea>
                @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="karyawan_id" class="form-label">Penanggung Jawab</label>
                <select name="karyawan_id" id="karyawan_id" class="form-select @error('karyawan_id') is-invalid @enderror"
                    required>
                    <option disabled value="">-- Pilih Karyawan --</option>
                    @foreach($karyawans as $karyawan)
                        <option value="{{ $karyawan->id }}" {{ old('karyawan_id', $project->karyawan_id) == $karyawan->id ? 'selected' : '' }}>
                            {{ $karyawan->nama_karyawan }} — {{ $karyawan->departemen->nama_departemen }}
                        </option>
                    @endforeach
                </select>
                @error('karyawan_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="status_project" class="form-label">Status</label>
                <select name="status_project" id="status_project"
                    class="form-select @error('status_project') is-invalid @enderror" required>
                    <option disabled value="">-- Pilih Status --</option>
                    @foreach(['belum dimulai', 'dalam pengerjaan', 'selesai'] as $status)
                        <option value="{{ $status }}" {{ old('status_project', $project->status_project) == $status ? 'selected' : '' }}>
                            {{ ucfirst($status) }}
                        </option>
                    @endforeach
                </select>
                @error('status_project') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="deadline" class="form-label">Deadline</label>
                <input type="date" name="deadline" id="deadline"
                    class="form-control @error('deadline') is-invalid @enderror"
                    value="{{ old('deadline', $project->deadline) }}" required
                    min="{{ \Carbon\Carbon::tomorrow()->format('Y-m-d') }}">
                @error('deadline') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('project.show', $project->id) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update Project</button>
            </div>
        </form>
    </div>
@endsection