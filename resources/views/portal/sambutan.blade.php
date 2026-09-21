@extends('layouts.portal')

@section('title', 'Sambutan Kepala Sekolah')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">Sambutan Kepala Sekolah</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Selamat datang di portal informasi {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-sm p-4 p-md-5">
                <div class="row align-items-start">
                    <div class="col-md-4 text-center mb-4 mb-md-0">
                        <img src="{{ $settings->principal_photo_url }}" alt="Kepala Sekolah" class="img-fluid rounded shadow-sm w-100" style="max-height: 320px; object-fit: cover;">
                        <h5 class="fw-bold mt-3 mb-0">{{ $settings->principal_name ?? 'H. Muhamad Solihin, S.Pd., M.M.' }}</h5>
                        <p class="text-muted small">Kepala {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
                    </div>
                    <div class="col-md-8 ps-md-4">
                        <h4 class="fw-bold text-dark mb-4 border-bottom pb-2">Bismillahirrohmanirrohim</h4>
                        <div class="text-muted" style="text-align: justify; font-size: 0.975rem; line-height: 1.8;">
                            {!! nl2br($settings->principal_speech) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
