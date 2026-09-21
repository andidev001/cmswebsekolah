@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Overview')

@section('content')
<div class="row">
    <!-- Stat Cards -->
    <div class="col-sm-6 col-lg-3">
        <div class="card card-border-shadow-primary">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-primary" style="background-color: rgba(115,103,240,0.1); color: #7367f0; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; border-radius: 0.375rem;">
                            <i class="fa-solid fa-user-tie"></i>
                        </span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $stats['teachers'] }}</h4>
                        <small class="text-muted">Total Guru & Staff</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-border-shadow-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-success" style="background-color: rgba(40,199,111,0.1); color: #28c76f; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; border-radius: 0.375rem;">
                            <i class="fa-solid fa-newspaper"></i>
                        </span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $stats['posts'] }}</h4>
                        <small class="text-muted">Artikel Blog</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-border-shadow-warning">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-warning" style="background-color: rgba(255,159,67,0.1); color: #ff9f43; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; border-radius: 0.375rem;">
                            <i class="fa-solid fa-graduation-cap"></i>
                        </span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $stats['alumni'] }}</h4>
                        <small class="text-muted">Database Alumni</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card card-border-shadow-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="avatar me-3">
                        <span class="avatar-initial rounded bg-label-info" style="background-color: rgba(0,186,209,0.1); color: #00bad1; width: 44px; height: 44px; display: flex; align-items: center; justify-content: center; font-size: 1.3rem; border-radius: 0.375rem;">
                            <i class="fa-solid fa-envelope"></i>
                        </span>
                    </div>
                    <div>
                        <h4 class="mb-0 fw-bold">{{ $stats['messages'] }}</h4>
                        <small class="text-muted">Pesan Masuk</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Recent Posts -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold text-dark">Artikel & Berita Terbaru</h5>
                <a href="{{ route('admin.posts') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Kategori</th>
                                <th>Views</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_posts as $post)
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark">{{ Str::limit($post->title, 40) }}</div>
                                    <small class="text-muted">{{ $post->created_at->format('d M Y') }}</small>
                                </td>
                                <td><span class="badge bg-label-secondary" style="background-color: #f1f0f2; color: #6f6b7d;">{{ $post->category->name }}</span></td>
                                <td><i class="fa-regular fa-eye me-1 text-muted"></i> {{ $post->views }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">Belum ada artikel.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="col-md-6 mb-4">
        <div class="card h-100">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="m-0 fw-bold text-dark">Pesan Hubungi Kami Terbaru</h5>
                <a href="{{ route('admin.messages') }}" class="btn btn-sm btn-primary">Lihat Semua</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Pengirim</th>
                                <th>Subjek</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_messages as $msg)
                            <tr>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $msg->name }}</div>
                                    <small class="text-muted">{{ $msg->email }}</small>
                                </td>
                                <td>{{ Str::limit($msg->subject ?? 'Tanpa Subjek', 35) }}</td>
                                <td><small class="text-muted">{{ $msg->created_at->format('d M Y H:i') }}</small></td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">Belum ada pesan masuk.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
