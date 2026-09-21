@extends('layouts.portal')

@section('title', 'Ekstrakurikuler')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">Ekstrakurikuler</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Wadah Pengembangan Bakat & Minat Siswa {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    <div class="row">
        @forelse($ekskuls as $eks)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                    <img src="{{ $eks->photo_url }}" alt="{{ $eks->name }}" style="height: 200px; object-fit: cover;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold text-dark mb-2">{{ $eks->name }}</h5>
                        <p class="text-muted small mb-3"><i class="fa-solid fa-user-shield text-info me-1"></i> Pembina: <strong>{{ $eks->coach ?? '-' }}</strong></p>
                        <p class="text-muted mb-0" style="font-size: 0.9rem; text-align: justify;">{{ $eks->description }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                Belum ada data ekstrakurikuler yang dipublikasikan.
            </div>
        @endforelse
    </div>
</div>
@endsection
