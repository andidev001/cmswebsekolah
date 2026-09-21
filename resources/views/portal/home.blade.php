@extends('layouts.portal')

@section('title', 'Beranda')

@section('content')
<!-- Hero Slider Carousel -->
<div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="6000">
    @if($carousels->count() > 0)
        <div class="carousel-indicators">
            @foreach($carousels as $index => $slide)
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}" aria-current="{{ $index == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($carousels as $index => $slide)
                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}" style="height: 520px; background: linear-gradient(rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.65)), url('{{ $slide->image_url }}') no-repeat center center; background-size: cover;">
                    <div class="container h-100 d-flex align-items-center">
                        <div class="col-lg-8 text-white">
                            @if($slide->title)
                                <h1 class="display-4 fw-bold mb-3">{{ $slide->title }}</h1>
                            @endif
                            @if($slide->subtitle)
                                <p class="lead mb-4">{{ $slide->subtitle }}</p>
                            @endif
                            @if($slide->button_text && $slide->button_link)
                                <div class="d-flex gap-3">
                                    <a href="{{ $slide->button_link }}" class="btn btn-primary btn-lg px-4 rounded-pill shadow-sm">{{ $slide->button_text }}</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Fallback static slider when no slides in DB -->
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <!-- Slide 1 -->
            <div class="carousel-item active" style="height: 520px; background: linear-gradient(rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.65)), url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=1200&q=80') no-repeat center center; background-size: cover;">
                <div class="container h-100 d-flex align-items-center">
                    <div class="col-lg-8 text-white">
                        <span class="badge bg-primary mb-3 px-3 py-2 text-uppercase fs-7" style="letter-spacing: 1px;">Selamat Datang</span>
                        <h1 class="display-4 fw-bold mb-3">Selamat Datang di Portal Resmi {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</h1>
                        <p class="lead mb-4">Lembaga pendidikan vokasi terakreditasi A yang unggul, berkarakter islami, menguasai IPTEK, dan berdaya saing tinggi di era globalisasi.</p>
                        <div class="d-flex gap-3">
                            <a href="{{ route('portal.visi-misi') }}" class="btn btn-outline-light btn-lg px-4 rounded-pill">Visi & Misi</a>
                            @if($settings->external_ppdb_link)
                                <a href="{{ $settings->external_ppdb_link }}" target="_blank" class="btn btn-ppdb btn-lg text-white"><i class="fa-solid fa-user-plus me-1"></i> PPDB Online</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Slide 2 -->
            <div class="carousel-item" style="height: 520px; background: linear-gradient(rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.65)), url('https://images.unsplash.com/photo-1581092921461-eab62e97a780?auto=format&fit=crop&w=1200&q=80') no-repeat center center; background-size: cover;">
                <div class="container h-100 d-flex align-items-center">
                    <div class="col-lg-8 text-white">
                        <span class="badge bg-info mb-3 px-3 py-2 text-uppercase fs-7" style="letter-spacing: 1px;">Kompetensi Keahlian</span>
                        <h1 class="display-4 fw-bold mb-3">Pendidikan Vokasi Berbasis Industri</h1>
                        <p class="lead mb-4">Mempersiapkan siswa dengan kompetensi keahlian Teknik Komputer Jaringan, Teknik Bisnis Sepeda Motor, dan Teknik Kendaraan Ringan yang selaras dengan dunia industri modern.</p>
                        <a href="{{ route('portal.fasilitas') }}" class="btn btn-info btn-lg px-4 text-white rounded-pill">Lihat Fasilitas</a>
                    </div>
                </div>
            </div>
            <!-- Slide 3 -->
            <div class="carousel-item" style="height: 520px; background: linear-gradient(rgba(15, 23, 42, 0.65), rgba(15, 23, 42, 0.65)), url('https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&w=1200&q=80') no-repeat center center; background-size: cover;">
                <div class="container h-100 d-flex align-items-center">
                    <div class="col-lg-8 text-white">
                        <span class="badge bg-success mb-3 px-3 py-2 text-uppercase fs-7" style="letter-spacing: 1px;">Prestasi Siswa</span>
                        <h1 class="display-4 fw-bold mb-3">Mencetak Generasi Berprestasi</h1>
                        <p class="lead mb-4">Kami tidak hanya mengajarkan keahlian teknis, melainkan juga menanamkan akhlak karimah, etos kerja, serta melahirkan siswa-siswa berprestasi tingkat provinsi dan nasional.</p>
                        <a href="{{ route('portal.prestasi') }}" class="btn btn-success btn-lg px-4 text-white rounded-pill">Lihat Prestasi</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>

<!-- Welcoming speech / Sambutan Kepala Sekolah -->
<section class="section-padding bg-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 mb-4 mb-lg-0 text-center">
                <div class="position-relative d-inline-block">
                    <img src="{{ $settings->principal_photo_url }}" alt="Kepala Sekolah" class="img-fluid rounded shadow-lg" style="max-height: 400px; object-fit: cover;">
                    <div class="bg-primary text-white p-3 rounded shadow position-absolute bottom-0 start-50 translate-middle-x w-80 text-center" style="transform: translateY(20px) !important;">
                        <h6 class="mb-0 fw-bold">{{ $settings->principal_name ?? 'H. Muhamad Solihin, S.Pd., M.M.' }}</h6>
                        <small style="font-size: 0.8rem; opacity: 0.85;">Kepala Sekolah</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 ps-lg-5 mt-4 mt-lg-0">
                <span class="text-uppercase text-secondary fw-bold" style="font-size: 0.85rem; letter-spacing: 1px;">Sambutan Hangat</span>
                <h2 class="fw-bold text-dark mt-1 mb-3">Sambutan Kepala {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</h2>
                <div class="text-muted mb-4" style="text-align: justify; font-size: 0.95rem;">
                    {!! nl2br(Str::limit($settings->principal_speech, 450)) !!}
                </div>
                <a href="{{ route('portal.sambutan') }}" class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">Baca Selengkapnya <i class="fa-solid fa-arrow-right ms-2"></i></a>
            </div>
        </div>
    </div>
</section>

<!-- Stats Counter Grid Section -->
<section class="section-padding bg-primary text-white position-relative" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 col-sm-6 mb-4 mb-md-0">
                <div class="p-3">
                    <i class="fa-solid fa-users-gear display-4 text-warning mb-3"></i>
                    <h2 class="fw-extrabold display-5 mb-0">{{ $teachers_count }}</h2>
                    <p class="text-slate-300 m-0" style="color: #cbd5e1;">Guru & Staff Pengajar</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-4 mb-md-0">
                <div class="p-3">
                    <i class="fa-solid fa-school display-4 text-warning mb-3"></i>
                    <h2 class="fw-extrabold display-5 mb-0">{{ $ekskul_count }}</h2>
                    <p class="text-slate-300 m-0" style="color: #cbd5e1;">Ekstrakurikuler Aktif</p>
                </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div class="p-3">
                    <i class="fa-solid fa-user-graduate display-4 text-warning mb-3"></i>
                    <h2 class="fw-extrabold display-5 mb-0">{{ $alumni_count }}</h2>
                    <p class="text-slate-300 m-0" style="color: #cbd5e1;">Alumni Terdata</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section: Guru & Staf Carousel -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-title-container text-center mb-4">
            <span class="text-uppercase text-secondary fw-bold d-block mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">Tenaga Pendidik</span>
            <h2 class="section-title">Guru & Staf Pengajar</h2>
        </div>
        
        @if(count($teachers) > 0)
            <!-- Swiper Container -->
            <div class="position-relative px-md-5">
                <div class="swiper homeTeacherSwiper py-3">
                    <div class="swiper-wrapper">
                        @foreach($teachers as $teacher)
                            <div class="swiper-slide">
                                <div class="teacher-slider-card">
                                    <!-- Card Top -->
                                    <div class="card-header-section">
                                        <div class="text-white card-identity">
                                            <h5 class="fw-bold text-uppercase name-text m-0" title="{{ $teacher->name }}">{{ $teacher->name }}</h5>
                                            <div class="position-text mt-2 small">
                                                <i class="fa-solid fa-user me-1"></i> {{ $teacher->position }}
                                            </div>
                                        </div>
                                        <div class="photo-container shadow-sm">
                                            <img src="{{ $teacher->photo_url }}" 
                                                 alt="{{ $teacher->name }}" 
                                                 class="photo-img">
                                        </div>
                                    </div>

                                    <!-- Dotted Divider -->
                                    <div class="card-dotted-divider"></div>

                                    <!-- Card Middle Details -->
                                    <div class="card-details-section text-center text-white">
                                        <div class="detail-item">Status : {{ $teacher->nip ? 'PNS' : 'GTT / PTT' }}</div>
                                        <div class="detail-item">NIP : {{ $teacher->nip ?? '-' }}</div>
                                        <div class="detail-item">NUPTK : -</div>
                                        <div class="detail-item">HP/WA : -</div>
                                        <div class="detail-item">Email : -</div>
                                    </div>

                                    <!-- Card Footer -->
                                    <div class="card-footer-section d-flex justify-content-between align-items-center mt-3">
                                        <div class="social-icons d-flex gap-2">
                                            <a href="#" class="social-link-icon"><i class="fa-brands fa-facebook-f"></i></a>
                                            <a href="#" class="social-link-icon"><i class="fa-brands fa-instagram"></i></a>
                                        </div>
                                        <button class="btn-lihat-custom" 
                                                data-name="{{ $teacher->name }}" 
                                                data-position="{{ $teacher->position }}" 
                                                data-nip="{{ $teacher->nip ?? '-' }}" 
                                                data-photo="{{ $teacher->photo_url }}">
                                            Lihat <i class="fa-regular fa-eye ms-1"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <!-- Pagination dots -->
                    <div class="swiper-pagination-custom text-center mt-4"></div>
                </div>
                <!-- Navigation buttons on sides -->
                <button class="btn-swiper-prev d-none d-md-flex"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="btn-swiper-next d-none d-md-flex"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
            
            <div class="text-center mt-4">
                <a href="{{ route('portal.guru') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-users me-1"></i> Lihat Semua Guru & Staf</a>
            </div>
        @else
            <div class="py-5 text-center text-muted">
                <p>Belum ada data guru pengajar yang dipublikasikan.</p>
            </div>
        @endif
    </div>
</section>

<!-- Section: Ekstrakurikuler -->
<section class="section-padding bg-white">
    <div class="container">
        <div class="section-title-container text-center mb-4">
            <span class="text-uppercase text-secondary fw-bold d-block mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">Pengembangan Bakat</span>
            <h2 class="section-title">Ekstrakurikuler Pilihan</h2>
        </div>
        
        <div class="row">
            @forelse($ekskuls->take(3) as $eks)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden card-hover-effect">
                        <div class="img-zoom-container" style="height: 200px; overflow: hidden; position: relative;">
                            <img src="{{ $eks->photo_url }}" alt="{{ $eks->name }}" class="w-100 h-100 object-fit-cover transition-img">
                            <div class="coach-badge position-absolute bottom-0 start-0 m-3 px-3 py-1 bg-primary text-white rounded-pill small" style="font-size:0.75rem;">
                                <i class="fa-solid fa-user-shield me-1"></i> {{ $eks->coach ?? 'Pembina' }}
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-2">{{ $eks->name }}</h5>
                            <p class="text-muted mb-0" style="font-size: 0.9rem; text-align: justify; line-height: 1.6;">{{ Str::limit($eks->description, 140) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    Belum ada data ekstrakurikuler yang dipublikasikan.
                </div>
            @endforelse
        </div>
        
        @if($ekskuls->count() > 0)
            <div class="text-center mt-4">
                <a href="{{ route('portal.ekskul') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-volleyball me-1"></i> Lihat Semua Ekstrakurikuler</a>
            </div>
        @endif
    </div>
</section>

<!-- Section: Fasilitas Sekolah -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-title-container text-center mb-4">
            <span class="text-uppercase text-secondary fw-bold d-block mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">Sarana & Prasarana</span>
            <h2 class="section-title">Fasilitas Belajar Terbaik</h2>
        </div>
        
        <div class="row">
            @forelse($facilities->take(3) as $fac)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm overflow-hidden card-hover-effect">
                        <div class="img-zoom-container" style="height: 200px; overflow: hidden;">
                            <img src="{{ $fac->photo_url }}" alt="{{ $fac->name }}" class="w-100 h-100 object-fit-cover transition-img">
                        </div>
                        <div class="card-body p-4">
                            <h5 class="fw-bold text-dark mb-3">{{ $fac->name }}</h5>
                            <p class="text-muted mb-0" style="font-size: 0.9rem; text-align: justify; line-height: 1.6;">{{ Str::limit($fac->description, 140) }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 text-muted">
                    Belum ada data fasilitas sekolah yang dipublikasikan.
                </div>
            @endforelse
        </div>
        
        @if($facilities->count() > 0)
            <div class="text-center mt-4">
                <a href="{{ route('portal.fasilitas') }}" class="btn btn-outline-primary px-4 py-2 rounded-pill shadow-sm"><i class="fa-solid fa-building me-1"></i> Lihat Semua Fasilitas</a>
            </div>
        @endif
    </div>
</section>

<!-- Teacher Detail Modal -->
<div class="modal fade" id="teacherDetailModal" tabindex="-1" aria-labelledby="teacherDetailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px; overflow: hidden;">
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold" id="teacherDetailModalLabel">Profil Lengkap Pendidik</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <img src="" id="modal-teacher-photo" class="rounded-circle shadow mb-3 border border-4 border-white" style="width: 120px; height: 120px; object-fit: cover;">
                <h4 class="fw-bold text-dark mb-1" id="modal-teacher-name"></h4>
                <p class="text-primary fw-semibold mb-3" id="modal-teacher-position"></p>
                
                <hr class="my-3 text-muted opacity-25">
                
                <div class="row text-start justify-content-center px-3">
                    <div class="col-12 col-md-10">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-medium">Status Kepegawaian</span>
                            <span class="text-dark fw-bold" id="modal-teacher-status"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-medium">NIP</span>
                            <span class="text-dark fw-bold" id="modal-teacher-nip"></span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-medium">NUPTK</span>
                            <span class="text-dark fw-bold">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-medium">HP/WA</span>
                            <span class="text-dark fw-bold">-</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted fw-medium">Email</span>
                            <span class="text-dark fw-bold">-</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 pt-0 justify-content-center">
                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-modal="hide" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Announcements and Agendas in 2 Columns -->
<section class="section-padding">
    <div class="container">
        <div class="row">
            <!-- Announcements Column -->
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h4 class="fw-bold text-dark m-0"><i class="fa-solid fa-bullhorn text-primary me-2"></i> Pengumuman Terbaru</h4>
                    <a href="{{ route('portal.pengumuman') }}" class="text-decoration-none text-primary fw-semibold" style="font-size: 0.9rem;">Lihat Semua <i class="fa-solid fa-angles-right"></i></a>
                </div>
                <div class="d-flex flex-column gap-3">
                    @forelse($announcements as $ann)
                    <div class="card border-0 shadow-sm p-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light text-primary border" style="font-size: 0.75rem;"><i class="fa-regular fa-clock me-1"></i> {{ $ann->date->format('d M Y') }}</span>
                        </div>
                        <h6 class="fw-bold"><a href="{{ route('portal.pengumuman.detail', $ann->slug) }}" class="text-decoration-none text-dark hover-primary">{{ $ann->title }}</a></h6>
                        <p class="text-muted m-0" style="font-size: 0.85rem; text-align: justify;">{{ Str::limit(strip_tags($ann->content), 120) }}</p>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">Belum ada pengumuman terbaru.</div>
                    @endforelse
                </div>
            </div>

            <!-- Agendas Column -->
            <div class="col-lg-6 ps-lg-4">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h4 class="fw-bold text-dark m-0"><i class="fa-solid fa-calendar-days text-primary me-2"></i> Agenda Kegiatan</h4>
                    <a href="{{ route('portal.agenda') }}" class="text-decoration-none text-primary fw-semibold" style="font-size: 0.9rem;">Lihat Semua <i class="fa-solid fa-angles-right"></i></a>
                </div>
                <div class="d-flex flex-column gap-3">
                    @forelse($agendas as $age)
                    <div class="card border-0 shadow-sm p-3 d-flex flex-row gap-3 align-items-center">
                        <div class="bg-primary text-white text-center rounded p-2 d-flex flex-column justify-content-center" style="min-width: 65px; height: 65px;">
                            <span class="fw-bold fs-5 lh-1">{{ $age->date->format('d') }}</span>
                            <span class="fs-7 text-uppercase" style="font-size: 0.65rem;">{{ $age->date->format('M') }}</span>
                        </div>
                        <div>
                            <h6 class="fw-bold mb-1">{{ $age->title }}</h6>
                            <div class="d-flex gap-3 text-muted" style="font-size: 0.8rem;">
                                <span><i class="fa-solid fa-location-dot text-danger me-1"></i> {{ $age->location }}</span>
                                <span><i class="fa-regular fa-clock text-info me-1"></i> {{ $age->time }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-5 text-muted">Belum ada agenda terdekat.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Blog Posts Section -->
<section class="section-padding bg-white">
    <div class="container">
        <div class="section-title-container text-center mb-4">
            <span class="text-uppercase text-secondary fw-bold d-block mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">Kabar & Informasi</span>
            <h2 class="section-title">Artikel & Berita Terbaru</h2>
        </div>
        <div class="row">
            @forelse($recent_posts as $post)
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                    <img src="{{ $post->image_url }}" alt="Image" class="card-img-top" style="height: 200px; object-fit: contain; background-color: #fafafa;">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="badge bg-light text-primary border" style="font-size: 0.75rem;">{{ $post->category->name }}</span>
                            <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> {{ $post->created_at->format('d M Y') }}</small>
                        </div>
                        <h5 class="card-title fw-bold" style="font-size: 1.1rem; line-height: 1.4;"><a href="{{ route('portal.artikel.detail', $post->slug) }}" class="text-decoration-none text-dark hover-primary">{{ $post->title }}</a></h5>
                        <p class="card-text text-muted mb-3" style="font-size: 0.85rem; text-align: justify;">{{ Str::limit(strip_tags($post->content), 120) }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-0">
                        <a href="{{ route('portal.artikel.detail', $post->slug) }}" class="text-decoration-none text-primary fw-semibold" style="font-size: 0.9rem;">Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i></a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5 text-muted">Belum ada artikel dipublikasikan.</div>
            @endforelse
        </div>
    </div>
</section>

<!-- Maps & Contact Form section -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="section-title-container text-center mb-4">
            <span class="text-uppercase text-secondary fw-bold d-block mb-2" style="font-size: 0.85rem; letter-spacing: 1px;">Koneksi</span>
            <h2 class="section-title">Hubungi & Temukan Kami</h2>
        </div>
        <div class="row">
            <!-- Google Maps Embed -->
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="card border-0 shadow-sm p-2 h-100">
                    @if($settings->maps_iframe)
                        {!! $settings->maps_iframe !!}
                    @else
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center h-100" style="min-height: 350px;">
                            Peta Google Maps belum dikonfigurasi.
                        </div>
                    @endif
                </div>
            </div>

            <!-- Contact Form -->
            <div class="col-lg-6 ps-lg-4">
                <div class="card border-0 shadow-sm p-4 h-100">
                    <h5 class="fw-bold mb-3 text-dark"><i class="fa-regular fa-paper-plane text-primary me-2"></i> Kirim Pesan Cepat</h5>
                    <form id="contact-portal-form">
                        <div class="mb-3">
                            <label for="name" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Masukkan nama lengkap Anda">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Masukkan alamat email aktif">
                        </div>
                        <div class="mb-3">
                            <label for="subject" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Subjek / Perihal</label>
                            <input type="text" class="form-control" id="subject" name="subject" placeholder="Contoh: Pertanyaan Kemitraan">
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Pesan Lengkap</label>
                            <textarea class="form-control" id="message" name="message" rows="4" required placeholder="Tulis isi pesan Anda..."></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="captcha" class="form-label" style="font-size: 0.85rem; font-weight: 500;">
                                Keamanan: Berapa hasil dari <span class="badge bg-primary px-2" id="contact-captcha-question">{{ $contact_captcha_question }}</span> ?
                            </label>
                            <input type="number" class="form-control" id="captcha" name="captcha" required placeholder="Jawaban angka">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2"><i class="fa-solid fa-paper-plane me-2"></i> Kirim Pesan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<!-- Swiper CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<style>
    /* Swiper Navigation Buttons */
    .btn-swiper-prev, .btn-swiper-next {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background-color: #f37021;
        color: #ffffff;
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .btn-swiper-prev:hover, .btn-swiper-next:hover {
        background-color: #ea580c;
        transform: scale(1.05);
    }
    
    .btn-swiper-prev:focus, .btn-swiper-next:focus {
        outline: none;
    }

    .position-relative .btn-swiper-prev,
    .position-relative .btn-swiper-next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 10;
    }
    .position-relative .btn-swiper-prev {
        left: 0;
    }
    .position-relative .btn-swiper-next {
        right: 0;
    }

    /* Teacher Card Styling */
    .teacher-slider-card {
        background: linear-gradient(180deg, #1fa5b9 0%, #0085f1 100%);
        border-radius: 20px;
        padding: 24px 20px;
        box-shadow: 0 10px 25px rgba(0, 133, 241, 0.15);
        min-height: 380px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    
    .teacher-slider-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 15px 30px rgba(0, 133, 241, 0.25);
    }
    
    .card-header-section {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }
    
    .card-identity {
        flex: 1;
        padding-right: 8px;
        text-align: left;
    }
    
    .name-text {
        font-family: 'Outfit', sans-serif;
        font-size: 1rem;
        letter-spacing: 0.5px;
        color: #ffffff;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 120px;
    }
    
    .position-text {
        font-weight: 500;
        opacity: 0.9;
        display: flex;
        align-items: center;
        color: #ffffff;
    }
    
    .photo-container {
        width: 80px;
        height: 100px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid rgba(255, 255, 255, 0.25);
        flex-shrink: 0;
        background: #0085f1;
    }
    
    .photo-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .card-dotted-divider {
        border-top: 2px dotted rgba(255, 255, 255, 0.4);
        margin: 18px 0;
        width: 100%;
    }
    
    .card-details-section {
        font-size: 0.85rem;
        line-height: 2;
        font-weight: 400;
        opacity: 0.95;
    }
    
    .detail-item {
        margin-bottom: 2px;
    }
    
    .social-link-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background-color: rgba(255, 255, 255, 0.15);
        color: #ffffff;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        font-size: 0.85rem;
        transition: all 0.2s ease;
    }
    
    .social-link-icon:hover {
        background-color: rgba(255, 255, 255, 0.3);
        color: #ffffff;
    }
    
    .btn-lihat-custom {
        background-color: #ffffff;
        color: #0085f1;
        border: none;
        border-radius: 50px;
        padding: 5px 18px;
        font-size: 0.825rem;
        font-weight: 600;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }
    
    .btn-lihat-custom:hover {
        background-color: #f1f5f9;
        transform: translateY(-1px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }
    
    /* Customize Swiper Bullets */
    .swiper-pagination-custom .swiper-pagination-bullet {
        width: 8px;
        height: 8px;
        background-color: #cbd5e1;
        opacity: 1;
        margin: 0 5px;
        transition: all 0.3s ease;
    }
    
    .swiper-pagination-custom .swiper-pagination-bullet-active {
        background-color: #f37021;
        width: 24px;
        border-radius: 4px;
    }

    /* Card Hover zoom effect */
    .card-hover-effect {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover-effect:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 20px rgba(0, 0, 0, 0.08) !important;
    }
    .img-zoom-container .transition-img {
        transition: transform 0.5s ease;
    }
    .card-hover-effect:hover .transition-img {
        transform: scale(1.08);
    }

    .hover-primary {
        transition: color 0.2s;
    }
    .hover-primary:hover {
        color: var(--portal-secondary) !important;
    }
</style>
@endpush

@push('scripts')
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
$(document).ready(function() {
    let teacherCount = {{ count($teachers) }};
    
    // Initialize Swiper
    let homeTeacherSwiper = new Swiper('.homeTeacherSwiper', {
        slidesPerView: 1,
        spaceBetween: 20,
        loop: teacherCount > 4,
        autoplay: {
            delay: 3500,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination-custom',
            clickable: true,
        },
        navigation: {
            nextEl: '.btn-swiper-next',
            prevEl: '.btn-swiper-prev',
        },
        breakpoints: {
            576: {
                slidesPerView: 2,
                spaceBetween: 20,
                loop: teacherCount > 2,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 25,
                loop: teacherCount > 3,
            },
            992: {
                slidesPerView: 4,
                spaceBetween: 30,
                loop: teacherCount > 4,
            }
        }
    });

    // Handle Detail Button Click
    $(document).on('click', '.btn-lihat-custom', function() {
        let name = $(this).data('name');
        let position = $(this).data('position');
        let nip = $(this).data('nip');
        let photo = $(this).data('photo');
        let status = (nip && nip !== '-') ? 'PNS' : 'GTT / PTT';

        $('#modal-teacher-name').text(name);
        $('#modal-teacher-position').text(position);
        $('#modal-teacher-nip').text(nip);
        $('#modal-teacher-status').text(status);
        
        let imgElem = $('#modal-teacher-photo');
        imgElem.attr('src', photo);
        imgElem.attr('onerror', `this.onerror=null; this.src='https://ui-avatars.com/api/?name=${encodeURIComponent(name)}&background=1e3a8a&color=fff&size=150';`);

        $('#teacherDetailModal').modal('show');
    });

    $('#contact-portal-form').on('submit', function(e) {
        e.preventDefault();

        let data = $(this).serialize();

        Swal.fire({
            title: 'Mengirim pesan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('portal.hubungi.kirim') }}",
            type: "POST",
            data: data,
            success: function(response) {
                Swal.close();
                if(response.success) {
                    $('#contact-portal-form')[0].reset();
                    if (response.new_captcha) {
                        $('#contact-captcha-question').text(response.new_captcha);
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Terkirim!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                let errorMsg = 'Gagal mengirim pesan. Silakan coba kembali nanti.';
                if(xhr.responseJSON) {
                    if (xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                    if (xhr.responseJSON.new_captcha) {
                        $('#contact-captcha-question').text(xhr.responseJSON.new_captcha);
                        $('#captcha').val('');
                    }
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan!',
                    html: errorMsg
                });
            }
        });
    });
});
</script>
@endpush
