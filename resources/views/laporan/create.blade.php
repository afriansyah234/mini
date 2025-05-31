@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h3 class="mb-4">Buat Laporan Baru</h3>

            <form action="{{ route('laporan.store') }}" method="POST">
                @csrf

                <div class="row g-3">
                    <div class="col-md-12">
                        <label for="tanggal_laporan" class="form-label">Tanggal Laporan</label>
                        <input type="date" name="tanggal_laporan" class="form-control" value="{{ now()->toDateString() }}" readonly>
                    </div>

                    <div class="col-md-12">
                        <label for="project_id" class="form-label">Nama Project</label>
                        <select name="project_id" id="project_id" class="form-control" required>
                            <option disabled selected>-- Pilih Project --</option>
                            @foreach ($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->nama_project }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="atas_nama" class="form-label">Atas Nama</label>
                        <input type="text" name="atas_nama" class="form-control" required>
                    </div>

                    <div class="col-md-12">
                        <label for="deskripsi_laporan" class="form-label">Deskripsi Laporan</label>
                        <textarea name="deskripsi_laporan" class="form-control" rows="4"></textarea>
                    </div>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-primary">Simpan Laporan</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
