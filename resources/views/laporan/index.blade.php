@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>Manajemen Tugas</h1>

                <!-- Search Form -->
                <form action="#" method="GET" class="mb-4">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="Cari tugas..."
                            value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Cari
                        </button>
                        @if(!empty($search))
                            <a href="#" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Reset
                            </a>
                        @endif
                    </div>
                </form>

                <!-- Task Table -->
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <!-- Table Headers -->
                                <thead>
                                    <tr>
                                        <th>Nama Tugas</th>
                                        <th>Deskripsi</th>
                                        <th>Project</th>
                                        <th>Status</th>
                                        <th>Tanggal Dibuat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>

                                <!-- Table Body -->
                                <tbody>
                                    @if($tugass->count() > 0)
                                        @foreach($tugass as $tugas)
                                            <tr>
                                                <td>{{ $tugas->nama_tugas }}</td>
                                                <td>{{ Str::limit($tugas->deskripsi, 50) }}</td>
                                                <td>{{ $tugas->project->nama_project }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $tugas->status->warna_status ?? 'secondary' }}">
                                                        {{ $tugas->status->nama_status }}
                                                    </span>
                                                </td>
                                                <td>{{ $tugas->created_at->format('d/m/Y H:i') }}</td>
                                                <td>
                                                    <!-- Action Buttons -->
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada data tugas</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $tugass->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection