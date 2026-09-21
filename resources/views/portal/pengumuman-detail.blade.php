@extends('layouts.portal')

@section('title', $announcement->title)

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-4" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-slate-300 text-decoration-none text-white">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('portal.pengumuman') }}" class="text-slate-300 text-decoration-none text-white">Pengumuman</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($announcement->title, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8 mb-5 mb-lg-0">
            <div class="card border-0 shadow-sm p-4 p-md-5">
                <div class="mb-3">
                    <span class="badge bg-light text-primary border" style="font-size: 0.8rem;"><i class="fa-regular fa-clock me-1"></i> Dipublikasikan: {{ $announcement->date->format('d M Y') }}</span>
                </div>
                <h2 class="fw-bold text-dark mb-4">{{ $announcement->title }}</h2>
                <div class="text-dark" style="font-size: 1.025rem; line-height: 1.8; text-align: justify; white-space: pre-line;">
                    {{ $announcement->content }}
                </div>
                <div class="border-top pt-4 mt-5">
                    <a href="{{ route('portal.pengumuman') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Daftar Pengumuman</a>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4 ps-lg-4">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom"><i class="fa-solid fa-bullhorn text-primary me-2"></i> Pengumuman Lainnya</h5>
                <div class="d-flex flex-column gap-3">
                    @forelse($recent_announcements as $recent)
                        <div>
                            <h6 class="fw-bold mb-1" style="font-size: 0.875rem; line-height: 1.4;">
                                <a href="{{ route('portal.pengumuman.detail', $recent->slug) }}" class="text-decoration-none text-dark hover-primary">{{ Str::limit($recent->title, 50) }}</a>
                            </h6>
                            <small class="text-muted" style="font-size: 0.75rem;">{{ $recent->date->format('d M Y') }}</small>
                        </div>
                    @empty
                        <p class="text-muted small">Tidak ada pengumuman lain.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.hover-primary {
    transition: color 0.2s;
}
.hover-primary:hover {
    color: var(--portal-secondary) !important;
}
</style>
@endpush
