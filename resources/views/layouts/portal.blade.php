<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title') - {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</title>

    <!-- Favicon -->
    @if (isset($settings))
        <link rel="icon" type="image/x-icon" href="{{ $settings->school_logo_url }}">
    @else
        <link rel="icon" type="image/x-icon"
            href="https://ui-avatars.com/api/?name={{ urlencode($settings->school_name ?? 'SMK Yapisda') }}&background=1e3a8a&color=fff&size=100">
    @endif

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <!-- Google Fonts Outfit & Inter -->
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">

    <style>
        :root {
            @if (isset($settings) && $settings->theme === 'emerald')
                --portal-primary: #047857;
                /* Emerald Green */
                --portal-primary-hover: #065f46;
                --portal-secondary: #10b981;
                --portal-accent: #f59e0b;
                --portal-body-bg: #f8fafc;
                --portal-text-dark: #0f172a;
                --portal-text-light: #475569;
            @elseif(isset($settings) && $settings->theme === 'crimson')
                --portal-primary: #be123c;
                /* Crimson Red */
                --portal-primary-hover: #9f1239;
                --portal-secondary: #f43f5e;
                --portal-accent: #f59e0b;
                --portal-body-bg: #f8fafc;
                --portal-text-dark: #0f172a;
                --portal-text-light: #475569;
            @elseif(isset($settings) && $settings->theme === 'amethyst')
                --portal-primary: #6d28d9;
                /* Purple */
                --portal-primary-hover: #5b21b6;
                --portal-secondary: #8b5cf6;
                --portal-accent: #f59e0b;
                --portal-body-bg: #f8fafc;
                --portal-text-dark: #0f172a;
                --portal-text-light: #475569;
            @elseif(isset($settings) && $settings->theme === 'dark')
                --portal-primary: #6366f1;
                /* Indigo Accent */
                --portal-primary-hover: #4f46e5;
                --portal-secondary: #818cf8;
                --portal-accent: #fbbf24;
                --portal-body-bg: #0f172a;
                /* Sleek Dark Mode Background */
                --portal-text-dark: #f8fafc;
                --portal-text-light: #cbd5e1;
            @else
                --portal-primary: #1e3a8a;
                /* Default Navy Blue */
                --portal-primary-hover: #1e40af;
                --portal-secondary: #0ea5e9;
                /* Light Blue */
                --portal-accent: #f59e0b;
                /* Orange */
                --portal-body-bg: #f8fafc;
                --portal-text-dark: #1e293b;
                --portal-text-light: #64748b;
            @endif
        }

        @if (isset($settings) && $settings->theme === 'dark')
            /* Dark Theme Overrides */
            body {
                background-color: #0f172a !important;
                color: #cbd5e1 !important;
            }

            .text-dark,
            h1,
            h2,
            h3,
            h4,
            h5,
            h6,
            .lead {
                color: #f8fafc !important;
            }

            .text-muted {
                color: #94a3b8 !important;
            }

            .bg-white,
            .card,
            .portal-navbar,
            .dropdown-menu,
            .modal-content {
                background-color: #1e293b !important;
                color: #cbd5e1 !important;
                border-color: #334155 !important;
            }

            .dropdown-item,
            .nav-link {
                color: #cbd5e1 !important;
            }

            .dropdown-item:hover,
            .nav-link:hover,
            .nav-link.active {
                background-color: #334155 !important;
                color: #ffffff !important;
            }

            .form-control,
            .form-select {
                background-color: #0f172a !important;
                border-color: #334155 !important;
                color: #f8fafc !important;
            }

            .form-control::placeholder {
                color: #475569 !important;
            }

            .bg-light,
            .section-padding.bg-light {
                background-color: #1e293b !important;
            }

            .border,
            .border-bottom,
            .border-top {
                border-color: #334155 !important;
            }

            .footer-links a {
                color: #94a3b8 !important;
            }

            .footer-links a:hover {
                color: var(--portal-secondary) !important;
            }

            .card-title a {
                color: #f8fafc !important;
            }

            /* Swiper navigation custom colors */
            .btn-swiper-prev,
            .btn-swiper-next {
                background-color: var(--portal-primary) !important;
            }

            .btn-swiper-prev:hover,
            .btn-swiper-next:hover {
                background-color: var(--portal-primary-hover) !important;
            }

            /* Stats counter grid slate background overlay */
            .text-slate-300 {
                color: #cbd5e1 !important;
            }
        @endif

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--portal-body-bg);
            color: var(--portal-text-dark);
            line-height: 1.6;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .outfit-font {
            font-family: 'Outfit', sans-serif;
        }

        /* Top Bar */
        .portal-topbar {
            background-color: #0f172a;
            color: #cbd5e1;
            font-size: 0.825rem;
            padding: 8px 0;
            border-bottom: 1px solid #1e293b;
        }

        .portal-topbar a {
            color: #cbd5e1;
            text-decoration: none;
            transition: color 0.2s;
        }

        .portal-topbar a:hover {
            color: var(--portal-secondary);
        }

        /* Navbar */
        .portal-navbar {
            background-color: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border-bottom: 3px solid var(--portal-primary);
            padding: 15px 0;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .navbar-brand img {
            height: 55px;
            object-fit: contain;
        }

        .brand-text {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-weight: 800;
            font-size: 1.3rem;
            color: var(--portal-primary);
            line-height: 1.1;
            margin: 0;
        }

        .brand-subtitle {
            font-size: 0.75rem;
            color: var(--portal-text-light);
            font-weight: 500;
            margin: 0;
        }

        .nav-link {
            font-weight: 600;
            color: var(--portal-text-dark);
            font-size: 0.95rem;
            padding: 8px 16px !important;
            transition: all 0.2s ease;
            border-radius: 4px;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--portal-primary) !important;
            background-color: rgba(30, 58, 138, 0.04);
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            border-top: 3px solid var(--portal-secondary);
            border-radius: 0 0 8px 8px;
            padding: 10px 0;
        }

        .dropdown-item {
            font-weight: 500;
            padding: 8px 20px;
            color: var(--portal-text-dark);
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: rgba(14, 165, 233, 0.06);
            color: var(--portal-secondary);
            padding-left: 24px;
        }

        /* PPDB Button */
        .btn-ppdb {
            background-color: var(--portal-secondary);
            color: #ffffff !important;
            font-weight: 700;
            border-radius: 50px;
            padding: 8px 22px !important;
            transition: all 0.3s;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.15);
        }

        .btn-ppdb:hover {
            background-color: var(--portal-primary) !important;
            color: #ffffff !important;
            box-shadow: 0 6px 12px -2px rgba(0, 0, 0, 0.2);
            transform: translateY(-1px);
        }

        /* Footer */
        .portal-footer {
            background-color: #0f172a;
            color: #e2e8f0;
            padding: 70px 0 30px;
            margin-top: 60px;
            border-top: 4px solid var(--portal-secondary);
        }

        .footer-logo {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 25px;
        }

        .footer-logo img {
            height: 60px;
        }

        .footer-logo h4 {
            font-weight: 800;
            color: #ffffff;
            margin: 0;
        }

        .footer-section-title {
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 10px;
        }

        .footer-section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 3px;
            background-color: var(--portal-secondary);
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 12px;
        }

        .footer-links a {
            color: #cbd5e1;
            text-decoration: none;
            transition: all 0.2s;
            display: inline-block;
        }

        .footer-links a:hover {
            color: var(--portal-secondary);
            transform: translateX(5px);
        }

        .footer-contact-item {
            display: flex;
            gap: 12px;
            margin-bottom: 15px;
            font-size: 0.925rem;
            color: #cbd5e1;
        }

        .footer-contact-item i {
            color: var(--portal-secondary);
            font-size: 1.1rem;
            margin-top: 3px;
        }

        .footer-bottom {
            border-top: 1px solid #1e293b;
            padding-top: 25px;
            margin-top: 50px;
            font-size: 0.85rem;
            color: #94a3b8;
        }

        .footer-social-icons {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .footer-social-icons a {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background-color: #1e293b;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            transition: all 0.2s;
            text-decoration: none;
        }

        .footer-social-icons a:hover {
            background-color: var(--portal-secondary);
            transform: scale(1.1);
        }

        /* Widgets & Sections */
        .section-padding {
            padding: 60px 0;
        }

        .section-title-container {
            text-align: center;
            margin-bottom: 45px;
        }

        .section-title {
            font-weight: 800;
            color: var(--portal-primary);
            position: relative;
            display: inline-block;
            padding-bottom: 12px;
            margin-bottom: 10px;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background-color: var(--portal-secondary);
            border-radius: 2px;
        }

        /* Responsive */
        @media (max-width: 991.98px) {
            .navbar-brand img {
                height: 45px;
            }

            .brand-title {
                font-size: 1.1rem;
            }

            .btn-ppdb {
                display: inline-block;
                margin-top: 10px;
                text-align: center;
                width: 100%;
            }
        }

        /* WhatsApp Chat Widget Styles */
        .wa-chat-widget {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 9999;
            font-family: 'Inter', sans-serif;
        }

        .wa-chat-bubble-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: #25d366;
            color: #ffffff;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            animation: pulse-wa 2s infinite;
        }

        .wa-chat-bubble-btn:hover {
            background-color: #128c7e;
            transform: scale(1.08);
            color: #ffffff;
        }

        .wa-chat-bubble-btn:focus {
            outline: none;
        }

        .wa-chat-badge-dot {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 12px;
            height: 12px;
            background-color: #ef4444;
            border-radius: 50%;
            border: 2px solid #ffffff;
        }

        .wa-chat-window {
            width: 320px;
            border-radius: 15px;
            overflow: hidden;
            position: absolute;
            bottom: 80px;
            right: 0;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            transform-origin: bottom right;
        }

        .wa-chat-header {
            background-color: var(--portal-primary);
            padding: 16px 20px;
            color: #ffffff;
        }

        .btn-close-wa-chat {
            background: transparent;
            border: none;
            color: #ffffff;
            font-size: 1.1rem;
            opacity: 0.8;
            cursor: pointer;
            transition: opacity 0.2s;
        }

        .btn-close-wa-chat:hover {
            opacity: 1;
        }

        .btn-wa-start {
            background-color: #25d366;
            transition: background-color 0.2s;
            text-decoration: none;
        }

        .btn-wa-start:hover {
            background-color: #128c7e;
            color: #ffffff !important;
        }

        @keyframes pulse-wa {
            0% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.6);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(37, 211, 102, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(37, 211, 102, 0);
            }
        }

        @if (isset($settings) && $settings->theme === 'dark')
            .wa-chat-body {
                background-color: #1e293b !important;
                color: #cbd5e1 !important;
            }

            .wa-welcome-text {
                color: #94a3b8 !important;
            }
        @endif
    </style>
    @stack('styles')
</head>

<body>

    <!-- Top Bar -->
    <div class="portal-topbar d-none d-md-block">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex gap-4">
                    <span><i class="fa-solid fa-envelope me-2 text-info"></i>
                        {{ $settings->email ?? 'info@sekolah.sch.id' }}</span>
                    <span><i class="fa-solid fa-phone me-2 text-info"></i>
                        {{ $settings->phone ?? '(021) 5968123' }}</span>
                </div>
                <div class="d-flex gap-3">
                    @if ($settings->facebook_url)
                        <a href="{{ $settings->facebook_url }}" target="_blank"><i
                                class="fa-brands fa-facebook"></i></a>
                    @endif
                    @if ($settings->instagram_url)
                        <a href="{{ $settings->instagram_url }}" target="_blank"><i
                                class="fa-brands fa-instagram"></i></a>
                    @endif
                    @if ($settings->youtube_url)
                        <a href="{{ $settings->youtube_url }}" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg portal-navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ $settings->school_logo_url }}" alt="Logo">
                <div class="brand-text">
                    <span class="brand-title">{{ $settings->school_name }}</span>
                    @if(isset($settings->slogan))
                        <span class="brand-subtitle">{{ $settings->slogan }}</span>
                    @endif
                </div>
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">Beranda</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Route::is('portal.sambutan') || Route::is('portal.visi-misi') || Route::is('portal.guru') || Route::is('portal.jurusan') || Route::is('portal.ekskul') || Route::is('portal.fasilitas') ? 'active' : '' }}"
                            href="#" id="navbarDropdownProfile" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Profil
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownProfile">
                            <li><a class="dropdown-item" href="{{ route('portal.sambutan') }}">Sambutan Kepala
                                    Sekolah</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.visi-misi') }}">Visi & Misi</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.guru') }}">Guru & Staff</a></li>
                            @if(isset($settings) && in_array($settings->jenjang, ['sma', 'smk']))
                            <li><a class="dropdown-item" href="{{ route('portal.jurusan') }}">Jurusan / Keahlian</a></li>
                            @endif
                            <li><a class="dropdown-item" href="{{ route('portal.ekskul') }}">Ekstrakurikuler</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.fasilitas') }}">Fasilitas Sekolah</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('portal.artikel*') ? 'active' : '' }}"
                            href="{{ route('portal.artikel') }}">Berita & Blog</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle {{ Route::is('portal.pengumuman*') || Route::is('portal.agenda*') || Route::is('portal.prestasi*') ? 'active' : '' }}"
                            href="#" id="navbarDropdownInfo" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Informasi
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdownInfo">
                            <li><a class="dropdown-item" href="{{ route('portal.pengumuman') }}">Pengumuman</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.agenda') }}">Agenda Kegiatan</a></li>
                            <li><a class="dropdown-item" href="{{ route('portal.prestasi') }}">Prestasi Siswa</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::is('portal.alumni*') ? 'active' : '' }}"
                            href="{{ route('portal.alumni') }}">Alumni</a>
                    </li>
                    <li class="nav-item me-lg-3">
                        <a class="nav-link {{ Route::is('portal.hubungi*') ? 'active' : '' }}"
                            href="{{ route('portal.hubungi') }}">Kontak</a>
                    </li>

                    @if ($settings->ppdb_active ?? 1)
                    <li class="nav-item">
                        <a class="nav-link btn-ppdb text-white"
                            href="{{ route('portal.ppdb') }}">
                            <i class="fa-solid fa-user-plus me-1"></i> PPDB Online
                        </a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Yield -->
    @yield('content')

    <!-- Footer -->
    <footer class="portal-footer">
        <div class="container">
            <div class="row">
                <!-- Info Column -->
                <div class="col-lg-4 mb-4 mb-lg-0">
                    <div class="footer-logo">
                        <img src="{{ $settings->school_logo_url }}" alt="Logo">
                        <h4>{{ $settings->school_name }}</h4>
                    </div>
                    <p class="text-slate-400" style="font-size: 0.9rem; color: #cbd5e1;">Mencetak lulusan kompeten,
                        profesional, berakhlak mulia, berjiwa wirausaha, dan berdaya saing global untuk menyambut masa
                        depan yang gemilang.</p>
                    <div class="footer-social-icons">
                        @if ($settings->facebook_url)
                            <a href="{{ $settings->facebook_url }}" target="_blank"><i
                                    class="fa-brands fa-facebook-f"></i></a>
                        @endif
                        @if ($settings->instagram_url)
                            <a href="{{ $settings->instagram_url }}" target="_blank"><i
                                    class="fa-brands fa-instagram"></i></a>
                        @endif
                        @if ($settings->youtube_url)
                            <a href="{{ $settings->youtube_url }}" target="_blank"><i
                                    class="fa-brands fa-youtube"></i></a>
                        @endif
                    </div>
                </div>

                <!-- Fast Links -->
                <div class="col-sm-6 col-lg-3 offset-lg-1 mb-4 mb-lg-0">
                    <h5 class="footer-section-title">Peta Situs</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}"><i class="fa-solid fa-chevron-right me-2 text-slate-500"
                                    style="font-size: 0.75rem;"></i> Beranda</a></li>
                        <li><a href="{{ route('portal.visi-misi') }}"><i
                                    class="fa-solid fa-chevron-right me-2 text-slate-500"
                                    style="font-size: 0.75rem;"></i> Visi & Misi</a></li>
                        <li><a href="{{ route('portal.guru') }}"><i
                                    class="fa-solid fa-chevron-right me-2 text-slate-500"
                                    style="font-size: 0.75rem;"></i> Guru & Staff</a></li>
                        <li><a href="{{ route('portal.artikel') }}"><i
                                    class="fa-solid fa-chevron-right me-2 text-slate-500"
                                    style="font-size: 0.75rem;"></i> Berita & Artikel</a></li>
                        <li><a href="{{ route('portal.alumni') }}"><i
                                    class="fa-solid fa-chevron-right me-2 text-slate-500"
                                    style="font-size: 0.75rem;"></i> Tracer Alumni</a></li>
                        <li><a href="{{ route('portal.hubungi') }}"><i
                                    class="fa-solid fa-chevron-right me-2 text-slate-500"
                                    style="font-size: 0.75rem;"></i> Kontak Kami</a></li>
                    </ul>
                </div>

                <!-- Contact Info -->
                <div class="col-sm-6 col-lg-4 mb-4 mb-lg-0">
                    <h5 class="footer-section-title">Kontak Sekolah</h5>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-location-dot"></i>
                        <span>{{ $settings->address ?? 'Jl. Raya Cisoka No.15, Cisoka, Kabupaten Tangerang, Banten' }}</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-phone"></i>
                        <span>{{ $settings->phone ?? '(021) 5968123' }}</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="fa-solid fa-envelope"></i>
                        <span>{{ $settings->email ?? 'info@sekolah.sch.id' }}</span>
                    </div>
                </div>
            </div>

            <!-- Copyright and Credits -->
            <div class="footer-bottom text-center">
                <p class="m-0">&copy; {{ date('Y') }} <strong>{{ $settings->school_name }}</strong>. All
                    rights reserved.</p>
                <small class="text-slate-500">Dikembangkan untuk media informasi publik resmi {{ $settings->school_name }}.</small>
            </div>
        </div>
    </footer>

    <!-- WhatsApp Floating Chat Widget -->
    @if (isset($settings) && $settings->whatsapp_number)
        <div class="wa-chat-widget" id="wa-chat-widget">
            <!-- Jendela Chat -->
            <div class="wa-chat-window shadow-lg d-none" id="wa-chat-window">
                <!-- Header Jendela -->
                <div class="wa-chat-header d-flex align-items-center gap-3">
                    <img src="https://ui-avatars.com/api/?name=Admin+{{ urlencode($settings->school_name ?? 'Sekolah') }}&background=ffffff&color=0284c7&size=80"
                        alt="CS Avatar" class="rounded-circle" width="40" height="40">
                    <div>
                        <h6 class="wa-agent-name mb-0 fw-bold text-white">Layanan Informasi</h6>
                        <small class="wa-agent-status text-white opacity-75"><i
                                class="fa-solid fa-circle text-success-indicator me-1"
                                style="font-size: 0.6rem; color: #4ade80;"></i> Online</small>
                    </div>
                    <button class="btn-close-wa-chat ms-auto" id="btn-close-wa-chat"><i
                            class="fa-solid fa-xmark"></i></button>
                </div>
                <!-- Body Jendela -->
                <div class="wa-chat-body p-4">
                    <p class="wa-welcome-text text-muted mb-3"
                        style="font-size: 0.875rem; text-align: justify; line-height: 1.5; font-style: normal;">
                        {{ $settings->whatsapp_welcome_message ?? 'Halo! Ada yang bisa kami bantu? Silakan klik tombol di bawah untuk mulai chat via WhatsApp.' }}
                    </p>
                    <a href="https://wa.me/{{ $settings->whatsapp_number }}?text={{ urlencode('Halo ' . ($settings->school_name ?? 'Admin') . ', saya ingin bertanya mengenai...') }}"
                        target="_blank"
                        class="btn btn-wa-start d-flex align-items-center justify-content-center gap-2 w-100 py-2 text-white fw-bold rounded-pill">
                        <i class="fa-brands fa-whatsapp fs-5"></i> Mulai Chat WhatsApp
                    </a>
                </div>
            </div>

            <!-- Tombol Bubble Melayang -->
            <button class="wa-chat-bubble-btn shadow-lg" id="wa-chat-bubble-btn" title="Chat dengan Kami">
                <i class="fa-brands fa-whatsapp"></i>
                <span class="wa-chat-badge-dot"></span>
            </button>
        </div>
    @endif

    <!-- JQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Set up Ajax CSRF token globally for frontend
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            // WhatsApp Chat Widget toggle behavior
            $('#wa-chat-bubble-btn').on('click', function(e) {
                e.stopPropagation();
                $('#wa-chat-window').toggleClass('d-none');
            });

            $('#btn-close-wa-chat').on('click', function(e) {
                e.stopPropagation();
                $('#wa-chat-window').addClass('d-none');
            });

            // Close chat window if clicked outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#wa-chat-widget').length) {
                    $('#wa-chat-window').addClass('d-none');
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
