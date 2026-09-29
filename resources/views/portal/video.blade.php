@extends('layouts.portal')

@section('title', 'Kanal Video')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">Kanal Video</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Kumpulan dokumentasi dan informasi dalam bentuk video dari {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    @if($videos->count() > 0)
        <div class="row">
            @foreach($videos as $video)
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="card h-100 border-0 shadow-sm overflow-hidden rounded-3">
                    <div class="ratio ratio-16x9">
                        <iframe src="https://www.youtube.com/embed/{{ $video->youtube_id }}" title="{{ $video->title }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                    <div class="card-body p-4 bg-white">
                        <h6 class="card-title fw-bold text-dark lh-base mb-2" style="font-size: 1.05rem;">{{ $video->title }}</h6>
                        <small class="text-muted"><i class="fa-regular fa-clock me-1"></i> {{ $video->created_at->format('d M Y') }}</small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="d-flex justify-content-center mt-5">
            {{ $videos->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" alt="Empty" class="img-fluid mb-4" style="max-width: 250px; opacity: 0.8;">
            <h4 class="fw-bold text-dark mb-2">Belum ada video</h4>
            <p class="text-muted">Saat ini belum ada video yang dipublikasikan.</p>
        </div>
    @endif
</div>
@endsection
