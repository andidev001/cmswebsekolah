@extends('layouts.portal')

@section('title', 'Agenda Kegiatan')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">Agenda Kegiatan</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Kalender Aktivitas dan Agenda Pendidikan {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                @forelse($agendas as $age)
                    <div class="col-md-6 mb-4">
                        <div class="card border-0 shadow-sm p-4 h-100 d-flex flex-row gap-3 align-items-start">
                            <div class="bg-primary text-white text-center rounded p-3 d-flex flex-column justify-content-center align-items-center" style="min-width: 80px; height: 80px;">
                                <span class="fw-bold fs-4 lh-1">{{ $age->date->format('d') }}</span>
                                <span class="fs-7 text-uppercase" style="font-size: 0.7rem; letter-spacing: 0.5px;">{{ $age->date->format('M') }}</span>
                                <span class="fs-8" style="font-size: 0.6rem; opacity: 0.8;">{{ $age->date->format('Y') }}</span>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="fw-bold text-dark mb-2">{{ $age->title }}</h5>
                                <p class="text-muted mb-3" style="font-size: 0.875rem; text-align: justify;">{{ $age->description }}</p>
                                <div class="d-flex flex-wrap gap-3 text-muted" style="font-size: 0.825rem;">
                                    <span><i class="fa-solid fa-location-dot text-danger me-1"></i> Tempat: <strong>{{ $age->location }}</strong></span>
                                    <span><i class="fa-regular fa-clock text-info me-1"></i> Waktu: <strong>{{ $age->time }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5 text-muted">
                        Belum ada agenda kegiatan yang terjadwal.
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $agendas->links('pagination::bootstrap-5') }}
            </div>
        </div>
    </div>
</div>
@endsection
