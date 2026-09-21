@extends('layouts.portal')

@section('title', $post->title)

@section('content')
<!-- Page Header Banner (Condensed) -->
<div class="bg-primary text-white py-4" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-slate-300 text-decoration-none text-white">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('portal.artikel') }}" class="text-slate-300 text-decoration-none text-white">Artikel</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($post->title, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <!-- Main Article Content Column -->
        <div class="col-lg-8 mb-5 mb-lg-0">
            <div class="card border-0 shadow-sm p-4 p-md-5">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-secondary" style="font-size: 0.8rem;">{{ $post->category->name }}</span>
                    <span class="text-muted" style="font-size: 0.85rem;">
                        <i class="fa-regular fa-calendar-days me-1"></i> {{ $post->created_at->format('d M Y') }}
                    </span>
                    <span class="text-muted" style="font-size: 0.85rem; margin-left: 10px;">
                        <i class="fa-regular fa-eye me-1"></i> {{ $post->views }}x dilihat
                    </span>
                </div>
                
                <h1 class="fw-bold text-dark mb-4" style="font-size: 2rem; line-height: 1.3;">{{ $post->title }}</h1>
                
                <div class="mb-4 text-center">
                    <img src="{{ $post->image_url }}" alt="Image" class="img-fluid rounded w-100" style="max-height: 450px; object-fit: contain; background-color: #fafafa;">
                </div>

                <div class="article-body text-dark" style="font-size: 1.025rem; line-height: 1.8; text-align: justify;">
                    {!! $post->content !!}
                </div>

                <div class="border-top pt-4 mt-5 d-flex justify-content-between align-items-center" style="font-size: 0.875rem; color: #64748b;">
                    <span>Ditulis oleh: <strong>{{ $post->user->name ?? 'Admin' }}</strong></span>
                    <a href="{{ route('portal.artikel') }}" class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Artikel</a>
                </div>
            </div>
        </div>

        <!-- Sidebar Recent Posts Column -->
        <div class="col-lg-4 ps-lg-4">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom"><i class="fa-solid fa-newspaper text-primary me-2"></i> Artikel Lainnya</h5>
                <div class="d-flex flex-column gap-3">
                    @forelse($recent_posts as $recent)
                        <div class="d-flex gap-2">
                            <img src="{{ $recent->image_url }}" alt="Thumbnail" class="rounded" style="width: 70px; height: 50px; object-fit: cover; min-width: 70px;">
                            <div>
                                <h6 class="fw-bold mb-1" style="font-size: 0.85rem; line-height: 1.4;">
                                    <a href="{{ route('portal.artikel.detail', $recent->slug) }}" class="text-decoration-none text-dark hover-primary">{{ Str::limit($recent->title, 45) }}</a>
                                </h6>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $recent->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small">Tidak ada artikel lain.</p>
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
