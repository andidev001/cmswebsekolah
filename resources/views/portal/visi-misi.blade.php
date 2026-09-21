@extends('layouts.portal')

@section('title', 'Visi & Misi')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">Visi & Misi</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Target, Nilai, dan Arah Perjuangan {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Visi Card -->
            <div class="card border-0 shadow-sm p-4 p-md-5 mb-4 text-center">
                <span class="text-uppercase text-secondary fw-bold" style="font-size: 0.85rem; letter-spacing: 1px;">Arah Strategis</span>
                <h3 class="fw-bold text-dark mt-1 mb-4">Visi Sekolah</h3>
                <div class="p-3 bg-light rounded shadow-inner" style="font-size: 1.15rem; font-style: italic; color: #1e3a8a; line-height: 1.6;">
                    "{{ $settings->vision ?? ('Terwujudnya ' . ($settings->school_name ?? 'SMK Yapisda Cisoka') . ' sebagai lembaga pendidikan vokasi yang unggul, berkarakter islami, menguasai IPTEK, dan berdaya saing global.') }}"
                </div>
            </div>

            <!-- Misi Card -->
            <div class="card border-0 shadow-sm p-4 p-md-5">
                <span class="text-uppercase text-secondary fw-bold text-center" style="font-size: 0.85rem; letter-spacing: 1px;">Langkah Nyata</span>
                <h3 class="fw-bold text-dark text-center mt-1 mb-4">Misi Sekolah</h3>
                <div class="text-muted" style="font-size: 1rem; line-height: 1.8;">
                    @if($settings->mission)
                        <ul class="list-group list-group-flush">
                            @foreach(explode("\n", $settings->mission) as $misi)
                                @if(trim($misi) != '')
                                    <li class="list-group-item border-0 px-0 d-flex align-items-start gap-3">
                                        <i class="fa-solid fa-circle-check text-primary mt-1" style="font-size: 1.1rem;"></i>
                                        <span>{{ ltrim(trim($misi), "0123456789. ") }}</span>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center">Misi sekolah belum dikonfigurasi.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
