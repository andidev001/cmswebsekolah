@extends('layouts.portal')

@section('title', 'Fasilitas Sekolah')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">Fasilitas Sekolah</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Sarana Prasarana Penunjang Kegiatan Belajar Praktik Menengah</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    <div class="row">
        @forelse($facilities as $fac)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                    <img src="{{ $fac->photo_url }}" alt="{{ $fac->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-3">{{ $fac->name }}</h5>
                        <p class="text-muted mb-0" style="font-size: 0.9rem; text-align: justify;">{{ $fac->description }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                Belum ada data fasilitas sekolah yang dipublikasikan.
            </div>
        @endforelse
    </div>
</div>
@endsection
