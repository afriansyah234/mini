@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="my-4">Project Kanban</h1>

        <div class="row">
            @foreach(['perencanaan', 'berjalan', 'ditunda', 'selesai'] as $status)
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-{{ $statusColors[$status] }} text-white">
                            {{ ucfirst($status) }}
                        </div>
                        <div class="card-body">
                            @foreach($projects->where('status.status_project', $status) as $project)
                                <div class="card mb-3">
                                    <div class="card-body">
                                        <h5>{{ $project->nama_project }}</h5>
                                        <p class="small">{{ $project->deskripsi }}</p>
                                        <p class="small">PIC: {{ $project->karyawan->nama_karyawan ?? '-' }}</p>

                                        <form method="POST" action="{{ route('project.update-status', $project->id) }}">
                                            @csrf
                                            <select name="status_id" class="form-select form-select-sm"
                                                onchange="this.form.submit()">
                                                @foreach($statuses as $statusOpt)
                                                    <option value="{{ $statusOpt->id }}" {{ $project->status_project == $statusOpt->id ? 'selected' : '' }}>
                                                        {{ $statusOpt->status_project }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection