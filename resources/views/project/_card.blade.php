<div class="col-md-4 mb-4">
    <div class="card h-100 shadow-lg">
        <div class="card-header d-flex justify-content-between align-items-center py-2">
            <h6 class="mb-0 fw-semibold">{{ $project->nama_project }}</h6>
            <div class="d-flex gap-1">
                <a class="btn btn-info btn-sm text-white" href="{{ route('project.show', $project->id) }}">
                    <i class="fas fa-eye fa-sm"></i>
                </a>
                <a href="{{ route('project.edit', $project->id) }}" class="btn btn-sm btn-warning text-white"
                    title="Edit">
                    <i class="fas fa-edit"></i>
                </a>
                <form action="{{ route('project.destroy', $project->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus project ini?')">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm">
                        <i class="fas fa-trash fa-sm"></i>
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body d-flex flex-column">
            <p class="card-text"><strong>Deskripsi :</strong> {{ $project->deskripsi }}</p>
            <p><strong>Status : </strong>
                @php
                    $today = \Carbon\Carbon::now();
                    $isLate = $project->deadline && \Carbon\Carbon::parse($project->deadline)->lt($today);

                    $badge = [
                        'perencanaan' => 'bg-secondary',
                        'berjalan' => 'bg-warning',
                        'ditunda' => 'bg-warning',
                        'selesai' => 'bg-success',
                    ][$project->status->status_project] ?? 'bg-secondary';

                    $statusLabel = ucfirst($project->status->status_project);
                    if ($isLate && $project->status->status_project !== 'selesai') {
                        $statusLabel .= ' (Telat)';
                        $badge = 'bg-danger'; // Ubah badge jadi merah
                    }
                @endphp
                <span class="badge {{ $badge }}">{{ $statusLabel }}</span>
            </p>

            <p><strong>Deadline:</strong>
                {{ $project->deadline ? \Carbon\Carbon::parse($project->deadline)->translatedFormat('d F Y') : '-' }}
            </p>
            <p><strong>Penanggung jawab:</strong> {{ $project->karyawan->nama_karyawan ?? '-' }}</p>
            <a href="{{ route('laporan.create', $project->id) }}" class="btn btn-primary btn-sm text-white w-full">
                <i class="fas fa-file-alt fa-sm"></i> Buat Laporan
            </a>
        </div>
    </div>
</div>