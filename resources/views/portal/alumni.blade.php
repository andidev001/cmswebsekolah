@extends('layouts.portal')

@section('title', 'Alumni & Tracer Study')

@section('content')
    <!-- Page Header Banner -->
    <div class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #1e3a8a, #0f172a) !important;">
        <div class="container text-center py-3">
            <h1 class="fw-bold m-0">Ikatan Alumni & Tracer Study</h1>
            <p class="lead m-0 mt-2 text-slate-300" style="color: #cbd5e1;">Menjalin Silaturahmi dan Melacak Jejak Sukses
                Lulusan {{ $settings->school_name ?? 'SMK Yapisda Cisoka' }}</p>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <!-- Alumni Directory & Testimonials Column (Left) -->
            <div class="col-lg-8 mb-5 mb-lg-0">
                <h4 class="fw-bold text-dark mb-4 border-bottom pb-2"><i
                        class="fa-solid fa-user-graduate text-primary me-2"></i> Kabar Alumni & Testimoni</h4>

                <div class="row">
                    @forelse($alumni as $alm)
                        <div class="col-md-6 mb-4">
                            <div class="card h-100 border-0 shadow-sm p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($alm->name) }}&background=1e3a8a&color=fff&size=80"
                                            alt="Avatar" class="rounded-circle shadow-sm" width="50" height="50">
                                        <div>
                                            <h6 class="fw-bold text-dark m-0">{{ $alm->name }}</h6>
                                            <small class="text-primary fw-medium" style="font-size: 0.8rem;">
                                                @if ($alm->tahun_ajaran)
                                                    Tahun Ajaran {{ $alm->tahun_ajaran }} (Lulus
                                                    {{ $alm->graduation_year }})
                                                @else
                                                    Lulusan Tahun {{ $alm->graduation_year }}
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                    @if ($alm->job)
                                        <div class="mb-3">
                                            <small class="badge bg-light text-info border" style="font-size: 0.725rem;"><i
                                                    class="fa-solid fa-briefcase text-info me-1"></i>
                                                {{ $alm->job }}</small>
                                        </div>
                                    @endif
                                    <p class="text-muted m-0"
                                        style="font-size: 0.9rem; text-align: justify; font-style: italic; line-height: 1.6;">
                                        "{{ $alm->testimonial ?? 'Bangga sekali menjadi bagian dari ' . ($settings->school_name ?? 'SMK Yapisda Cisoka') . '. Pendidikannya mempersiapkan kami siap menghadapi masa depan.' }}"
                                    </p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center py-5 text-muted">
                            Belum ada alumni yang mengisi data testimoni.
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $alumni->links('pagination::bootstrap-5') }}
                </div>
            </div>

            <!-- Alumni Register / Tracer Form Column (Right) -->
            <div class="col-lg-4 ps-lg-4">
                <div class="card border-0 shadow-sm p-4 sticky-lg-top" style="top: 100px; z-index: 10;">
                    <h5 class="fw-bold text-dark mb-2"><i class="fa-solid fa-pen-to-square text-primary me-2"></i> Isi
                        Tracer Study</h5>
                    <p class="text-muted small mb-4">Halo alumni! Bantu kami mendata lulusan dengan mengisi formulir
                        penelusuran alumni (Tracer Study) di bawah ini.</p>

                    <form id="alumni-portal-form">
                        <div class="mb-3">
                            <label for="name" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Nama
                                Lengkap</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                placeholder="Masukkan nama lengkap Anda">
                        </div>
                        <div class="row">
                            <div class="col-sm-6 mb-3">
                                <label for="graduation_year" class="form-label"
                                    style="font-size: 0.85rem; font-weight: 500;">Tahun Lulus</label>
                                <input type="number" class="form-control" id="graduation_year" name="graduation_year"
                                    required placeholder="Contoh: 2024" min="1970" max="{{ date('Y') + 1 }}">
                            </div>
                            <div class="col-sm-6 mb-3">
                                <label for="tahun_ajaran" class="form-label"
                                    style="font-size: 0.85rem; font-weight: 500;">Tahun Ajaran</label>
                                <input type="text" class="form-control" id="tahun_ajaran" name="tahun_ajaran"
                                    placeholder="Contoh: 2022/2023">
                            </div>
                        </div>

                        {{-- Untuk SMA/SMK: tampilkan pekerjaan dan melanjutkan sekolah --}}
                        @if(in_array($settings->jenjang ?? '', ['sma', 'smk']))
                        <div class="mb-3">
                            <label for="job" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Pekerjaan
                                Saat Ini</label>
                            <input type="text" class="form-control" id="job" name="job"
                                placeholder="Contoh: PT. Astra, Freelance, dll.">
                        </div>
                        <div class="mb-3">
                            <label for="melanjutkan_sekolah" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Melanjutkan Sekolah (Opsional)</label>
                            <input type="text" class="form-control" id="melanjutkan_sekolah" name="melanjutkan_sekolah"
                                placeholder="Contoh: Universitas Indonesia, D3 Politeknik, dll.">
                            <small class="text-muted">Jika saat ini sedang/akan melanjutkan pendidikan.</small>
                        </div>
                        @else
                        {{-- Untuk SD/SMP: hanya tampilkan melanjutkan sekolah --}}
                        <div class="mb-3">
                            <label for="melanjutkan_sekolah" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Melanjutkan Sekolah</label>
                            <input type="text" class="form-control" id="melanjutkan_sekolah" name="melanjutkan_sekolah"
                                placeholder="Contoh: SMP Negeri 1, MTs Al-Hidayah, dll.">
                        </div>
                        @endif

                        <div class="mb-3">
                            <label for="phone" class="form-label" style="font-size: 0.85rem; font-weight: 500;">No.
                                WhatsApp (Opsional)</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Masukkan nomor HP aktif">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Alamat
                                Email (Opsional)</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Masukkan alamat email Anda">
                        </div>
                        <div class="mb-3">
                            <label for="testimonial" class="form-label" style="font-size: 0.85rem; font-weight: 500;">Kesan
                                & Pesan / Testimoni</label>
                            <textarea class="form-control" id="testimonial" name="testimonial" rows="3"
                                placeholder="Bagaimana kesan Anda selama bersekolah di {{ $settings->school_name }}?"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="captcha" class="form-label" style="font-size: 0.85rem; font-weight: 500;">
                                Keamanan: Berapa hasil dari <span class="badge bg-primary px-2"
                                    id="captcha-question">{{ $captcha_question }}</span> ?
                            </label>
                            <input type="number" class="form-control" id="captcha" name="captcha" required
                                placeholder="Jawaban angka">
                        </div>
                        <button type="submit" class="btn btn-primary w-100 py-2"><i
                                class="fa-solid fa-paper-plane me-1"></i> Kirim Data Alumni</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#alumni-portal-form').on('submit', function(e) {
                e.preventDefault();

                let data = $(this).serialize();

                Swal.fire({
                    title: 'Mengirim data...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: "{{ route('portal.alumni.store') }}",
                    type: "POST",
                    data: data,
                    success: function(response) {
                        Swal.close();
                        if (response.success) {
                            $('#alumni-portal-form')[0].reset();
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.close();
                        let errorMsg =
                            'Gagal menyimpan data alumni. Silakan coba kembali nanti.';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                errorMsg = Object.values(xhr.responseJSON.errors).flat().join(
                                    '<br>');
                            }
                            if (xhr.responseJSON.new_captcha) {
                                $('#captcha-question').text(xhr.responseJSON.new_captcha);
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
