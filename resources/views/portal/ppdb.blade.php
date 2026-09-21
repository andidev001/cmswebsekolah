@extends('layouts.portal')

@section('title', 'Informasi PPDB')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, var(--portal-primary), var(--portal-primary-hover)) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0 text-white">Informasi PPDB</h1>
        <p class="lead m-0 mt-2 text-white" style="opacity: 0.9;">Penerimaan Peserta Didik Baru {{ $settings->school_name ?? 'Sekolah' }}</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-4 p-md-5">
                    <h3 class="fw-bold text-dark mb-4 text-center">Selamat Datang Calon Peserta Didik Baru!</h3>
                    
                    <div class="mb-5 text-muted" style="font-size: 1.1rem; line-height: 1.8;">
                        @if($settings->ppdb_content)
                            {!! nl2br(e($settings->ppdb_content)) !!}
                        @else
                            <p>
                                Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran ini telah dibuka. Kami mengundang putra-putri terbaik untuk bergabung dan berkembang bersama <strong>{{ $settings->school_name ?? 'Sekolah' }}</strong>.
                            </p>
                            <p>
                                Silakan persiapkan berkas-berkas persyaratan yang dibutuhkan sebelum mengisi formulir pendaftaran secara online. Pastikan data yang Anda masukkan adalah data yang valid dan dapat dipertanggungjawabkan.
                            </p>
                        @endif
                    </div>

                    <div class="row g-4 mb-5">
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded h-100 border-start border-4" style="border-color: var(--portal-secondary) !important;">
                                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-list-check text-primary me-2"></i> Persyaratan Umum</h5>
                                @php
                                    $reqs = $settings->ppdb_requirements ? explode("\n", $settings->ppdb_requirements) : [
                                        'Mengisi Formulir Pendaftaran',
                                        'Fotokopi Akta Kelahiran',
                                        'Fotokopi Kartu Keluarga (KK)',
                                        'Pas Foto Berwarna',
                                        'Fotokopi Ijazah / SKL (Menyusul)'
                                    ];
                                @endphp
                                <ul class="list-unstyled text-muted mb-0">
                                    @foreach($reqs as $req)
                                        @if(trim($req))
                                        <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i> {{ trim($req) }}</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="p-4 bg-light rounded h-100 border-start border-4" style="border-color: var(--portal-accent) !important;">
                                <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-calendar-alt text-primary me-2"></i> Jadwal Pendaftaran</h5>
                                @php
                                    $schedules = $settings->ppdb_schedule ? explode("\n", $settings->ppdb_schedule) : [
                                        'Gelombang 1: Januari - Maret',
                                        'Gelombang 2: April - Mei',
                                        'Gelombang 3: Juni - Juli'
                                    ];
                                @endphp
                                <ul class="list-unstyled text-muted mb-0">
                                    @foreach($schedules as $schedule)
                                        @if(trim($schedule))
                                            @php 
                                                $parts = explode(':', $schedule, 2); 
                                            @endphp
                                            @if(count($parts) > 1)
                                                <li class="mb-2"><strong>{{ trim($parts[0]) }}:</strong><br> {{ trim($parts[1]) }}</li>
                                            @else
                                                <li class="mb-2"><i class="fa-solid fa-calendar text-primary me-2"></i> {{ trim($schedule) }}</li>
                                            @endif
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-5 p-4 rounded" style="background-color: rgba(14, 165, 233, 0.05);">
                        <h4 class="fw-bold text-dark mb-3">Siap Untuk Mendaftar?</h4>
                        <p class="text-muted mb-4">Klik tombol di bawah ini untuk menuju ke halaman sistem pendaftaran (PPDB) online kami.</p>
                        
                        @if($settings->external_ppdb_link)
                            <a href="{{ $settings->external_ppdb_link }}" target="_blank" class="btn btn-lg px-5 py-3 rounded-pill fw-bold text-white shadow-sm hover-elevate" style="background-color: var(--portal-primary); transition: all 0.3s;">
                                <i class="fa-solid fa-paper-plane me-2"></i> Menuju Halaman PPDB
                            </a>
                        @else
                            <button class="btn btn-lg px-5 py-3 rounded-pill fw-bold text-white shadow-sm" style="background-color: #94a3b8; cursor: not-allowed;" disabled>
                                <i class="fa-solid fa-lock me-2"></i> Pendaftaran Belum Tersedia
                            </button>
                            <p class="text-danger mt-3 small">Link PPDB belum dikonfigurasi oleh administrator.</p>
                        @endif
                    </div>

                </div>
            </div>
            
            <div class="text-center mt-4">
                <p class="text-muted">Butuh bantuan? Silakan <a href="{{ route('portal.hubungi') }}" style="color: var(--portal-secondary); text-decoration: none; font-weight: 600;">Hubungi Kami</a></p>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-elevate:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        background-color: var(--portal-secondary) !important;
    }
</style>
@endsection
