<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $adminSettings = \App\Models\Setting::first();
    @endphp
    <title>@yield('title', 'Admin Dashboard') - {{ $adminSettings->school_name ?? 'SMK Yapisda Cisoka' }}</title>

    <!-- Favicon -->
    @if ($adminSettings)
        <link rel="icon" type="image/x-icon" href="{{ $adminSettings->school_logo_url }}">
    @else
        <link rel="icon" type="image/x-icon"
            href="https://ui-avatars.com/api/?name={{ urlencode($adminSettings->school_name ?? 'SMK Yapisda') }}&background=1e3a8a&color=fff&size=100">
    @endif

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Yajra Datatables Bootstrap 5 CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <!-- Custom Vuexy Stylesheet -->
    <link href="{{ asset('assets/css/vuexy.css') }}" rel="stylesheet">
    @stack('styles')
</head>

<body>

    <!-- Sidebar Layout -->
    <aside class="vx-sidebar" id="sidebar">
        <div class="vx-sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="vx-brand-logo">
                <i class="fa-solid fa-graduation-cap"></i>
                <span>CMS SKOLABS</span>
            </a>
            <button class="vx-navbar-toggle d-lg-none" id="sidebar-close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div class="vx-sidebar-menu">
            <ul class="p-0 m-0">
                <li class="vx-menu-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="vx-menu-link">
                        <i class="fa-solid fa-chart-pie"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <div class="vx-menu-header">Profil Sekolah</div>
                <li class="vx-menu-item {{ Route::is('admin.settings') ? 'active' : '' }}">
                    <a href="{{ route('admin.settings') }}" class="vx-menu-link">
                        <i class="fa-solid fa-sliders"></i>
                        <span>Pengaturan Sekolah</span>
                    </a>
                </li>
                @if(isset($adminSettings) && in_array($adminSettings->jenjang, ['sma', 'smk']))
                    <li class="vx-menu-item {{ Route::is('admin.majors*') ? 'active' : '' }}">
                        <a href="{{ route('admin.majors') }}" class="vx-menu-link">
                            <i class="fa-solid fa-graduation-cap"></i>
                            <span>Jurusan / Keahlian</span>
                        </a>
                    </li>
                @endif
                <li class="vx-menu-item {{ Route::is('admin.carousels*') ? 'active' : '' }}">
                    <a href="{{ route('admin.carousels.index') }}" class="vx-menu-link">
                        <i class="fa-solid fa-images"></i>
                        <span>Slider Beranda</span>
                    </a>
                </li>
                <li class="vx-menu-item {{ Route::is('admin.teachers*') ? 'active' : '' }}">
                    <a href="{{ route('admin.teachers') }}" class="vx-menu-link">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Data Guru & Staff</span>
                    </a>
                </li>
                <li class="vx-menu-item {{ Route::is('admin.facilities*') ? 'active' : '' }}">
                    <a href="{{ route('admin.facilities') }}" class="vx-menu-link">
                        <i class="fa-solid fa-building"></i>
                        <span>Fasilitas Sekolah</span>
                    </a>
                </li>
                <li class="vx-menu-item {{ Route::is('admin.extracurriculars*') ? 'active' : '' }}">
                    <a href="{{ route('admin.extracurriculars') }}" class="vx-menu-link">
                        <i class="fa-solid fa-volleyball"></i>
                        <span>Ekstrakurikuler</span>
                    </a>
                </li>

                <div class="vx-menu-header">Blog & Publikasi</div>
                <li class="vx-menu-item {{ Route::is('admin.categories*') ? 'active' : '' }}">
                    <a href="{{ route('admin.categories') }}" class="vx-menu-link">
                        <i class="fa-solid fa-tags"></i>
                        <span>Kategori Artikel</span>
                    </a>
                </li>
                <li class="vx-menu-item {{ Route::is('admin.posts*') ? 'active' : '' }}">
                    <a href="{{ route('admin.posts') }}" class="vx-menu-link">
                        <i class="fa-solid fa-newspaper"></i>
                        <span>Daftar Artikel/Blog</span>
                    </a>
                </li>

                <div class="vx-menu-header">Informasi Publik</div>
                <li class="vx-menu-item {{ Route::is('admin.announcements*') ? 'active' : '' }}">
                    <a href="{{ route('admin.announcements') }}" class="vx-menu-link">
                        <i class="fa-solid fa-bullhorn"></i>
                        <span>Pengumuman</span>
                    </a>
                </li>
                <li class="vx-menu-item {{ Route::is('admin.agendas*') ? 'active' : '' }}">
                    <a href="{{ route('admin.agendas') }}" class="vx-menu-link">
                        <i class="fa-solid fa-calendar-days"></i>
                        <span>Agenda Kegiatan</span>
                    </a>
                </li>
                <li class="vx-menu-item {{ Route::is('admin.achievements*') ? 'active' : '' }}">
                    <a href="{{ route('admin.achievements') }}" class="vx-menu-link">
                        <i class="fa-solid fa-trophy"></i>
                        <span>Prestasi Siswa</span>
                    </a>
                </li>

                <div class="vx-menu-header">Komunikasi & Alumni</div>
                <li class="vx-menu-item {{ Route::is('admin.alumni*') ? 'active' : '' }}">
                    <a href="{{ route('admin.alumni') }}" class="vx-menu-link">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Database Alumni</span>
                    </a>
                </li>
                <li class="vx-menu-item {{ Route::is('admin.messages*') ? 'active' : '' }}">
                    <a href="{{ route('admin.messages') }}" class="vx-menu-link">
                        <i class="fa-solid fa-envelope-open-text"></i>
                        <span>Pesan Masuk</span>
                    </a>
                </li>

                <div class="vx-menu-header">Manajemen Akses</div>
                <li class="vx-menu-item {{ Route::is('admin.users*') ? 'active' : '' }}">
                    <a href="{{ route('admin.users') }}" class="vx-menu-link">
                        <i class="fa-solid fa-users"></i>
                        <span>Data Pengguna</span>
                    </a>
                </li>
                <li class="vx-menu-item {{ Route::is('admin.roles*') ? 'active' : '' }}">
                    <a href="{{ route('admin.roles') }}" class="vx-menu-link">
                        <i class="fa-solid fa-shield-halved"></i>
                        <span>Peran / Role</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Container -->
    <div class="vx-content-wrapper">
        <!-- Floating Navbar -->
        <header class="vx-navbar">
            <div class="d-flex align-items-center">
                <button class="vx-navbar-toggle me-3" id="sidebar-toggle">
                    <i class="fa-solid fa-bars"></i>
                </button>
                <h5 class="m-0 font-weight-bold d-none d-sm-block">@yield('page-title', 'Dashboard')</h5>
            </div>
            <div class="d-flex align-items-center gap-3">
                <div class="dropdown">
                    <a href="#" class="d-flex align-items-center gap-2 text-decoration-none text-dark dropdown-toggle"
                        id="dropdownUser" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=7367f0&color=fff"
                            alt="avatar" class="rounded-circle" width="38" height="38">
                        <span class="d-none d-md-inline"
                            style="font-size: 0.9rem; font-weight: 500;">{{ Auth::user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" aria-labelledby="dropdownUser"
                        style="width: 200px;">
                        <li>
                            <div class="dropdown-header d-flex flex-column py-2">
                                <span class="fw-bold text-dark">{{ Auth::user()->name }}</span>
                                <small class="text-muted">{{ Auth::user()->email }}</small>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a href="/" target="_blank" class="dropdown-item">
                                <i class="fa-solid fa-globe me-2 text-muted"></i> Lihat Website
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="fa-solid fa-power-off me-2"></i> Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="vx-content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="vx-footer">
            <span>&copy; {{ date('Y') }} <strong>{{ $adminSettings->school_name ?? 'SMK Yapisda Cisoka' }}</strong>. All
                rights reserved.</span>
            <span class="d-none d-sm-inline">Made with | TEAM SKOLABS</span>
        </footer>
    </div>

    <!-- Modals stack -->
    @stack('modals')

    <!-- JQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Yajra Datatables Bootstrap 5 JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

    <!-- Sidebar and Responsive Script -->
    <script>
        $(document).ready(function () {
            // Sidebar toggles
            $('#sidebar-toggle').on('click', function () {
                $('#sidebar').addClass('active');
            });
            $('#sidebar-close').on('click', function () {
                $('#sidebar').removeClass('active');
            });
            $(document).on('click', function (e) {
                if ($(window).width() < 992) {
                    if (!$(e.target).closest('#sidebar').length && !$(e.target).closest('#sidebar-toggle')
                        .length) {
                        $('#sidebar').removeClass('active');
                    }
                }
            });

            // Set up Ajax CSRF token globally
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>