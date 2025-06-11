<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column pt-4" role="menu" data-accordion="false">

                <!-- Karyawan -->
                <li class="nav-item">
                    <a href="{{ route('karyawan.index') }}"
                        class="nav-link {{ request()->routeIs('karyawan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Karyawan</p>
                    </a>
                </li>

                <!-- Project -->
                <li class="nav-item">
                    <a href="{{ route('project.index') }}"
                        class="nav-link {{ request()->routeIs('project.index', 'project.create', 'project.edit') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-folder"></i>
                        <p>Project</p>
                    </a>
                </li>

                <!-- Riwayat Project -->
                <li class="nav-item">
                    <a href="{{ route('project.history') }}"
                        class="nav-link {{ request()->routeIs('project.history') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-history"></i>
                        <p>Riwayat Project</p>
                    </a>
                </li>
                <!-- Riwayat Tugas -->
                <li class="nav-item">
                    <a href="{{ route('tugas.history') }}"
                        class="nav-link {{ request()->routeIs('tugas.history') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-clipboard-check"></i>
                        <p>Riwayat Tugas</p>
                    </a>
                </li>

            </ul>
        </nav>
    </div>
</aside>