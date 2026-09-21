@extends('layouts.portal')

@section('title', isset($category) ? 'Artikel Kategori ' . $category->name : 'Berita & Artikel')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">{{ isset($category) ? 'Kategori: ' . $category->name : 'Berita & Artikel' }}</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Kumpulan Informasi dan Kabar Terkini {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <!-- Main Articles Column -->
        <div class="col-lg-8 mb-5 mb-lg-0">
            @if(request()->has('q'))
                <div class="alert alert-light border mb-4">
                    Hasil pencarian untuk kata kunci: <strong>"{{ request()->q }}"</strong>
                    <a href="{{ route('portal.artikel') }}" class="float-end text-decoration-none">Hapus Pencarian</a>
                </div>
            @endif

            <div class="row">
                @forelse($posts as $post)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden">
                            <img src="{{ $post->image_url }}" alt="Thumbnail" style="height: 180px; object-fit: contain; background-color: #fafafa;">
                            <div class="card-body p-4">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge bg-light text-primary border" style="font-size: 0.725rem;">{{ $post->category->name }}</span>
                                    <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> {{ $post->created_at->format('d M Y') }}</small>
                                </div>
                                <h5 class="fw-bold text-dark mb-2" style="font-size: 1.05rem; line-height: 1.4;">
                                    <a href="{{ route('portal.artikel.detail', $post->slug) }}" class="text-decoration-none text-dark hover-primary">{{ $post->title }}</a>
                                </h5>
                                <p class="text-muted small mb-0" style="text-align: justify;">{{ Str::limit(strip_tags($post->content), 100) }}</p>
                            </div>
                            <div class="card-footer bg-transparent border-0 px-4 pb-4 pt-0">
                                <a href="{{ route('portal.artikel.detail', $post->slug) }}" class="text-decoration-none text-primary fw-semibold" style="font-size: 0.85rem;">Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted">
                        Tidak ada artikel yang ditemukan.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $posts->appends(request()->query())->links('pagination::bootstrap-5') }}
            </div>
        </div>

        <!-- Sidebar Column -->
        <div class="col-lg-4 ps-lg-4">
            <!-- Search Widget -->
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-magnifying-glass text-primary me-2"></i> Cari Artikel</h5>
                <form action="{{ route('portal.artikel') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" name="q" value="{{ request()->q }}" placeholder="Kata kunci...">
                        <button class="btn btn-primary" type="submit"><i class="fa-solid fa-search"></i></button>
                    </div>
                </form>
            </div>

            <!-- Categories Widget -->
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-tags text-primary me-2"></i> Kategori Artikel</h5>
                <div class="list-group list-group-flush">
                    <a href="{{ route('portal.artikel') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 {{ !isset($category) ? 'text-primary fw-bold' : '' }}">
                        Semua Kategori
                    </a>
                    @foreach($categories as $cat)
                        <a href="{{ route('portal.artikel.category', $cat->slug) }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center px-0 {{ isset($category) && $category->id == $cat->id ? 'text-primary fw-bold' : '' }}">
                            {{ $cat->name }}
                            <span class="badge bg-secondary rounded-pill" style="font-size: 0.75rem;">{{ $cat->posts_count }}</span>
                        </a>
                    @endforeach
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
