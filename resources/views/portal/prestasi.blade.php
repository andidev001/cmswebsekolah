@extends('layouts.portal')

@section('title', 'Prestasi Siswa')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">Prestasi Siswa</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Galeri Penghargaan dan Prestasi Membanggakan Siswa {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    <div class="row">
        @forelse($achievements as $ach)
            <div class="col-sm-6 col-md-4 col-lg-3 mb-4">
                <div class="card h-100 border-0 shadow-sm overflow-hidden">
                    <img src="{{ $ach->photo_url }}" alt="{{ $ach->title }}" style="height: 180px; object-fit: cover;">
                    <div class="card-body p-3">
                        <span class="badge bg-warning text-dark mb-2" style="font-size: 0.7rem;"><i class="fa-solid fa-trophy me-1"></i> Prestasi</span>
                        <h6 class="fw-bold text-dark mb-2" style="line-height: 1.4;">{{ $ach->title }}</h6>
                        <p class="text-muted small mb-2"><i class="fa-solid fa-user text-info me-1"></i> {{ $ach->student_name }}</p>
                        <p class="text-muted small m-0" style="text-align: justify; font-size: 0.825rem;">{{ $ach->description }}</p>
                    </div>
                    <div class="card-footer bg-transparent border-0 px-3 pb-3 pt-0">
                        <small class="text-muted" style="font-size: 0.75rem;"><i class="fa-regular fa-calendar-days me-1"></i> {{ $ach->date ? $ach->date->format('d M Y') : '-' }}</small>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5 text-muted">
                Belum ada data prestasi yang dipublikasikan.
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $achievements->links('pagination::bootstrap-5') }}
    </div>
</div>
@endsection
