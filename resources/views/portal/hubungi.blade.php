@extends('layouts.portal')

@section('title', 'Hubungi Kami')

@section('content')
<!-- Page Header Banner -->
<div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
    <div class="container text-center py-3">
        <h1 class="fw-bold m-0">Hubungi Kami</h1>
        <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Kritik, Saran, Pertanyaan, Maupun Kemitraan Sangat Kami Harapkan</p>
    </div>
</div>

<!-- Main content -->
<div class="container my-5">
    <div class="row">
        <!-- Contact details column -->
        <div class="col-lg-5 mb-5 mb-lg-0">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h4 class="fw-bold text-dark mb-4 border-bottom pb-2">Informasi Kontak</h4>
                
                <div class="d-flex gap-3 mb-4">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-location-dot fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Alamat Sekolah</h6>
                        <span class="text-muted small">{{ $settings->address ?? 'Alamat sekolah belum dikonfigurasi' }}</span>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-phone fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Nomor Telepon</h6>
                        <span class="text-muted small">{{ $settings->phone ?? '-' }}</span>
                    </div>
                </div>

                <div class="d-flex gap-3 mb-4">
                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 50px; height: 50px; min-width: 50px;">
                        <i class="fa-solid fa-envelope fs-5"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Email Sekolah</h6>
                        <span class="text-muted small">{{ $settings->email ?? 'info@sekolah.sch.id' }}</span>
                    </div>
                </div>

                <!-- Social media -->
                <h5 class="fw-bold text-dark mt-3 mb-3">Sosial Media Resmi</h5>
                <div class="d-flex gap-2">
                    @if($settings->facebook_url)
                        <a href="{{ $settings->facebook_url }}" target="_blank" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fa-brands fa-facebook-f text-primary"></i></a>
                    @endif
                    @if($settings->instagram_url)
                        <a href="{{ $settings->instagram_url }}" target="_blank" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fa-brands fa-instagram text-danger"></i></a>
                    @endif
                    @if($settings->youtube_url)
                        <a href="{{ $settings->youtube_url }}" target="_blank" class="btn btn-outline-secondary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;"><i class="fa-brands fa-youtube text-danger"></i></a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Contact form column -->
        <div class="col-lg-7 ps-lg-4">
            <div class="card border-0 shadow-sm p-4 mb-4">
                <h4 class="fw-bold text-dark mb-4 border-bottom pb-2">Kirim Pesan Cepat</h4>
                <form id="contact-portal-page-form">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Nama Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required placeholder="Nama lengkap Anda">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Alamat Email</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Alamat email Anda">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="subject" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Subjek / Perihal</label>
                        <input type="text" class="form-control" id="subject" name="subject" placeholder="Masukkan perihal pertanyaan Anda">
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Pesan Anda</label>
                        <textarea class="form-control" id="message" name="message" rows="5" required placeholder="Tulis isi pesan lengkap di sini..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="captcha" class="form-label" style="font-size: 0.85rem; font-weight: 500;">
                            Keamanan: Berapa hasil dari <span class="badge bg-primary px-2" id="contact-page-captcha-question">{{ $contact_captcha_question }}</span> ?
                        </label>
                        <input type="number" class="form-control" id="captcha" name="captcha" required placeholder="Jawaban angka">
                    </div>
                    <button type="submit" class="btn btn-primary px-4 py-2"><i class="fa-solid fa-paper-plane me-2"></i> Kirim Pesan</button>
                </form>
            </div>
            
            <!-- Map Card -->
            <div class="card border-0 shadow-sm p-2">
                @if($settings->maps_iframe)
                    {!! $settings->maps_iframe !!}
                @else
                    <div class="bg-secondary text-white d-flex align-items-center justify-content-center rounded" style="min-height: 250px;">
                        Peta Google Maps belum dikonfigurasi.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#contact-portal-page-form').on('submit', function(e) {
        e.preventDefault();

        let data = $(this).serialize();

        Swal.fire({
            title: 'Mengirim pesan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('portal.hubungi.kirim') }}",
            type: "POST",
            data: data,
            success: function(response) {
                Swal.close();
                if(response.success) {
                    $('#contact-portal-page-form')[0].reset();
                    if (response.new_captcha) {
                        $('#contact-page-captcha-question').text(response.new_captcha);
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Terkirim!',
                        text: response.message,
                        timer: 2000,
                        showConfirmButton: false
                    });
                }
            },
            error: function(xhr) {
                Swal.close();
                let errorMsg = 'Gagal mengirim pesan. Silakan coba kembali nanti.';
                if(xhr.responseJSON) {
                    if (xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    }
                    if (xhr.responseJSON.new_captcha) {
                        $('#contact-page-captcha-question').text(xhr.responseJSON.new_captcha);
                        $('#captcha').val('');
                    }
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan!',
                    html: errorMsg
                });
            }
        });
    });
});
</script>
@endpush
