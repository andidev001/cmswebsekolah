@extends('layouts.portal')

@section('title', 'Guru & Staff')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">Guru & Staff Pengajar</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Para Pendidik Profesional {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    @if(count($teachers) > 0)
        <!-- Title & Navigation -->
        <div class="d-flex justify-content-between align-items-end mb-4">
            <div>
                <h3 class="fw-bold text-dark m-0">Guru</h3>
                <p class="text-muted m-0 small">Tenaga Pendidik dan Staf</p>
            </div>
            <div class="d-flex gap-2">
                <button class="btn-swiper-prev"><i class="fa-solid fa-chevron-left"></i></button>
                <button class="btn-swiper-next"><i class="fa-solid fa-chevron-right"></i></button>
            </div>
        </div>

        <!-- Swiper Container -->
        <div class="swiper teacherSwiper py-3">
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
    @else
        <div class="py-5 text-center text-muted">
            <h5>Belum ada data guru pengajar yang dipublikasikan.</h5>
        </div>
    @endif
</div>

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
                <button type="button" class="btn btn-secondary px-4 rounded-pill" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
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
</style>
@endpush

@push('scripts')
<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
$(document).ready(function() {
    let teacherCount = {{ count($teachers) }};
    
    // Initialize Swiper
    let teacherSwiper = new Swiper('.teacherSwiper', {
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
});
</script>
@endpush
