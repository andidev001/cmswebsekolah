@extends('layouts.portal')

@section('title', $post->title)

@section('content')
<!-- Page Header Banner (Condensed) -->
<div class="bg-primary text-white py-4" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container py-2">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2" style="font-size: 0.85rem;">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-slate-300 text-decoration-none text-white">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('portal.artikel') }}" class="text-slate-300 text-decoration-none text-white">Artikel</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">{{ Str::limit($post->title, 40) }}</li>
            </ol>
        </nav>
    </div>
</div>

<div class="container my-5">
    <div class="row">
        <!-- Main Article Content Column -->
        <div class="col-lg-8 mb-5 mb-lg-0">
            <div class="card border-0 shadow-sm p-4 p-md-5">
                <div class="d-flex align-items-center gap-2 mb-3">
                    <span class="badge bg-secondary" style="font-size: 0.8rem;">{{ $post->category->name }}</span>
                    <span class="text-muted" style="font-size: 0.85rem;">
                        <i class="fa-regular fa-calendar-days me-1"></i> {{ $post->created_at->format('d M Y') }}
                    </span>
                    <span class="text-muted" style="font-size: 0.85rem; margin-left: 10px;">
                        <i class="fa-regular fa-eye me-1"></i> {{ $post->views }}x dilihat
                    </span>
                </div>
                
                <h1 class="fw-bold text-dark mb-4" style="font-size: 2rem; line-height: 1.3;">{{ $post->title }}</h1>
                
                <div class="mb-4 text-center">
                    <img src="{{ $post->image_url }}" alt="Image" class="img-fluid rounded w-100" style="max-height: 450px; object-fit: contain; background-color: #fafafa;">
                </div>

                <div class="article-body text-dark" style="font-size: 1.025rem; line-height: 1.8; text-align: justify;">
                    {!! $post->content !!}
                </div>

                <div class="border-top pt-4 mt-5 d-flex flex-column flex-md-row justify-content-between align-items-center gap-3" style="font-size: 0.875rem; color: #64748b;">
                    <div class="d-flex align-items-center gap-3">
                        <span>Ditulis oleh: <strong>{{ $post->user->name ?? 'Admin' }}</strong></span>
                    </div>
                    
                    <div class="d-flex align-items-center gap-2">
                        <span class="fw-bold me-2">Bagikan:</span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" style="width: 32px; height: 32px; padding: 0; line-height: 30px;"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-sm btn-outline-info rounded-circle" style="width: 32px; height: 32px; padding: 0; line-height: 30px;"><i class="fa-brands fa-twitter"></i></a>
                        <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . request()->url()) }}" target="_blank" class="btn btn-sm btn-outline-success rounded-circle" style="width: 32px; height: 32px; padding: 0; line-height: 30px;"><i class="fa-brands fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="card border-0 shadow-sm p-4 p-md-5 mt-4">
                <h4 class="fw-bold mb-4"><i class="fa-solid fa-comments text-primary me-2"></i> Komentar ({{ $post->comments->where('is_approved', true)->count() }})</h4>
                
                <div class="comments-list mb-5">
                    @forelse($post->comments->where('is_approved', true) as $comment)
                        <div class="d-flex gap-3 mb-4 pb-4 border-bottom">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($comment->name) }}&background=random&color=fff" alt="Avatar" class="rounded-circle" width="50" height="50">
                            <div>
                                <h6 class="fw-bold mb-1">{{ $comment->name }}</h6>
                                <small class="text-muted mb-2 d-block">{{ $comment->created_at->format('d M Y H:i') }}</small>
                                <p class="mb-0 text-dark">{{ $comment->body }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center py-4 bg-light rounded">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                    @endforelse
                </div>

                <h5 class="fw-bold mb-3">Tinggalkan Komentar</h5>
                <form id="comment-form">
                    @csrf
                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="body" class="form-label">Komentar <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="body" name="body" rows="4" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-paper-plane me-2"></i> Kirim Komentar</button>
                </form>
            </div>
        </div>

        <!-- Sidebar Recent Posts Column -->
        <div class="col-lg-4 ps-lg-4">
            <div class="card border-0 shadow-sm p-4">
                <h5 class="fw-bold text-dark mb-3 pb-2 border-bottom"><i class="fa-solid fa-newspaper text-primary me-2"></i> Artikel Lainnya</h5>
                <div class="d-flex flex-column gap-3">
                    @forelse($recent_posts as $recent)
                        <div class="d-flex gap-2">
                            <img src="{{ $recent->image_url }}" alt="Thumbnail" class="rounded" style="width: 70px; height: 50px; object-fit: cover; min-width: 70px;">
                            <div>
                                <h6 class="fw-bold mb-1" style="font-size: 0.85rem; line-height: 1.4;">
                                    <a href="{{ route('portal.artikel.detail', $recent->slug) }}" class="text-decoration-none text-dark hover-primary">{{ Str::limit($recent->title, 45) }}</a>
                                </h6>
                                <small class="text-muted" style="font-size: 0.75rem;">{{ $recent->created_at->format('d M Y') }}</small>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted small">Tidak ada artikel lain.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.hover-primary {
    transition: color 0.2s;
}
.hover-primary:hover {
    color: var(--portal-secondary) !important;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#comment-form').on('submit', function(e) {
        e.preventDefault();
        
        let submitBtn = $(this).find('button[type="submit"]');
        submitBtn.prop('disabled', true).html('<i class="fa-solid fa-spinner fa-spin me-2"></i> Mengirim...');

        $.ajax({
            url: "{{ route('portal.komentar.store') }}",
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                if(response.success) {
                    Swal.fire('Berhasil', response.message, 'success');
                    $('#comment-form')[0].reset();
                }
                submitBtn.prop('disabled', false).html('<i class="fa-solid fa-paper-plane me-2"></i> Kirim Komentar');
            },
            error: function(xhr) {
                let errorMsg = 'Terjadi kesalahan.';
                if(xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                } else if(xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire('Error', errorMsg, 'error');
                submitBtn.prop('disabled', false).html('<i class="fa-solid fa-paper-plane me-2"></i> Kirim Komentar');
            }
        });
    });
});
</script>
@endpush
