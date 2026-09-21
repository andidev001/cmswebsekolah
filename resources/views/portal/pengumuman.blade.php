@extends('layouts.portal')

@section('title', 'Pengumuman Sekolah')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">Pengumuman Resmi</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Pusat Informasi Penting dan Rilis Akademik {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                @forelse($announcements as $ann)
                    <div class="col-md-6 mb-4">
                        <div class="card h-100 border-0 shadow-sm p-4 d-flex flex-column justify-content-between">
                            <div>
                                <div class="mb-2">
                                    <span class="badge bg-light text-primary border" style="font-size: 0.75rem;"><i class="fa-regular fa-clock me-1"></i> {{ $ann->date->format('d M Y') }}</span>
                                </div>
                                <h5 class="fw-bold mb-3"><a href="{{ route('portal.pengumuman.detail', $ann->slug) }}" class="text-decoration-none text-dark hover-primary">{{ $ann->title }}</a></h5>
                                <p class="text-muted" style="font-size: 0.9rem; text-align: justify; line-height: 1.6;">{{ Str::limit(strip_tags($ann->content), 180) }}</p>
                            </div>
                            <div class="border-top pt-3 mt-3">
                                <a href="{{ route('portal.pengumuman.detail', $ann->slug) }}" class="text-decoration-none text-primary fw-semibold" style="font-size: 0.85rem;">Selengkapnya <i class="fa-solid fa-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted">
                        Belum ada pengumuman yang dipublikasikan.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $announcements->links('pagination::bootstrap-5') }}
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
