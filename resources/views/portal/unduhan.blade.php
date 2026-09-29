@extends('layouts.portal')

@section('title', 'Unduhan File')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">Pusat Unduhan</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Kumpulan dokumen resmi dan informasi penting dari {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            @if($downloads->count() > 0)
                <div class="card border-0 shadow-sm p-4">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col" width="5%" class="text-center">No</th>
                                    <th scope="col" width="45%">Judul Dokumen</th>
                                    <th scope="col" width="30%">Deskripsi Singkat</th>
                                    <th scope="col" width="20%" class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($downloads as $index => $item)
                                    <tr>
                                        <td class="text-center fw-bold text-muted">{{ $downloads->firstItem() + $index }}</td>
                                        <td>
                                            <div class="d-flex align-items-center gap-3">
                                                <div class="bg-light p-2 rounded text-danger">
                                                    <i class="fa-solid fa-file-pdf fs-4"></i>
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold text-dark">{{ $item->title }}</h6>
                                                    <small class="text-muted"><i class="fa-regular fa-calendar me-1"></i> {{ $item->created_at->translatedFormat('d F Y') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-muted small">
                                            {{ $item->description ?? '-' }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ asset('storage/downloads/' . $item->file_path) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                                <i class="fa-solid fa-download me-1"></i> Unduh File
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $downloads->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-state-2130362-1800926.png" alt="Empty" class="img-fluid mb-4" style="max-width: 250px; opacity: 0.8;">
                    <h4 class="fw-bold text-dark mb-2">Belum ada file unduhan</h4>
                    <p class="text-muted">Saat ini belum ada dokumen yang dibagikan untuk publik.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
