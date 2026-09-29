@extends('layouts.portal')

@section('title', 'Kurikulum Sekolah')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">Kurikulum Sekolah</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Sistem Pembelajaran dan Panduan Akademik {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm p-4 p-md-5">
                <span class="text-uppercase text-secondary fw-bold text-center d-block" style="font-size: 0.85rem; letter-spacing: 1px;">Informasi Akademik</span>
                <h3 class="fw-bold text-dark text-center mt-1 mb-4">Struktur Kurikulum</h3>
                <div class="text-dark kurikulum-content" style="font-size: 1.05rem; line-height: 1.8;">
                    @if(!empty($settings->curriculum))
                        {!! $settings->curriculum !!}
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fa-solid fa-book-open fs-1 text-light mb-3"></i>
                            <p>Informasi kurikulum belum tersedia atau sedang dalam pembaruan.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .kurikulum-content h1, 
    .kurikulum-content h2, 
    .kurikulum-content h3, 
    .kurikulum-content h4 {
        color: #1e3a8a;
        font-weight: 700;
        margin-top: 1.5rem;
        margin-bottom: 1rem;
    }
    
    .kurikulum-content ul, 
    .kurikulum-content ol {
        padding-left: 1.5rem;
        margin-bottom: 1.5rem;
    }
    
    .kurikulum-content li {
        margin-bottom: 0.5rem;
    }
    
    .kurikulum-content table {
        width: 100% !important;
        margin-bottom: 1.5rem;
        border-collapse: collapse;
    }
    
    .kurikulum-content table td, 
    .kurikulum-content table th {
        border: 1px solid #dee2e6;
        padding: 0.75rem;
    }
    
    .kurikulum-content table th {
        background-color: #f8f9fa;
        font-weight: 600;
        color: #1e3a8a;
    }
</style>
@endpush
