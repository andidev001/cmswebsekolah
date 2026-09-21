@extends('layouts.admin')

@section('title', 'Pengaturan Sekolah')
@section('page-title', 'Pengaturan Profil Sekolah')

@section('content')
<div class="card">
    <div class="card-header border-bottom py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-sliders me-2 text-primary"></i> Pengaturan Informasi Sekolah</h5>
    </div>
    <div class="card-body">
        <form id="settings-form" enctype="multipart/form-data">
            <div class="row">
                <!-- Left Column: School Identity -->
                <div class="col-md-6 border-end">
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-school me-2"></i> Identitas Sekolah</h6>
                    
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="school_name" class="form-label">Nama Sekolah</label>
                            <input type="text" class="form-control" id="school_name" name="school_name" value="{{ $setting->school_name }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="jenjang" class="form-label">Jenjang</label>
                            <select class="form-select" id="jenjang" name="jenjang" required>
                                <option value="" disabled {{ !isset($setting->jenjang) ? 'selected' : '' }}>-- Pilih --</option>
                                <option value="sd" {{ ($setting->jenjang ?? '') == 'sd' ? 'selected' : '' }}>SD</option>
                                <option value="smp" {{ ($setting->jenjang ?? '') == 'smp' ? 'selected' : '' }}>SMP</option>
                                <option value="sma" {{ ($setting->jenjang ?? '') == 'sma' ? 'selected' : '' }}>SMA</option>
                                <option value="smk" {{ ($setting->jenjang ?? '') == 'smk' ? 'selected' : '' }}>SMK</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="slogan" class="form-label">Slogan / Moto Sekolah</label>
                        <input type="text" class="form-control" id="slogan" name="slogan" value="{{ $setting->slogan }}" placeholder="Contoh: Unggul, Berkarakter Islami & Berdaya Saing">
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="email" class="form-label">Email Sekolah</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $setting->email }}">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="phone" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $setting->phone }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label">Alamat Lengkap</label>
                        <textarea class="form-control" id="address" name="address" rows="3">{{ $setting->address }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="maps_iframe" class="form-label">Iframe Google Maps (Embed HTML)</label>
                        <textarea class="form-control" id="maps_iframe" name="maps_iframe" rows="3" placeholder="Paste kode iframe google maps di sini">{{ $setting->maps_iframe }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="school_logo" class="form-label">Logo Sekolah</label>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $setting->school_logo_url }}" alt="Logo" class="img-thumbnail" style="max-height: 80px;" id="logo-preview">
                            <input type="file" class="form-control" id="school_logo" name="school_logo" accept="image/*">
                        </div>
                        <small class="text-muted d-block mt-1">Ukuran maks: 2MB, format: PNG, JPG, JPEG</small>
                    </div>

                    <div class="mb-3">
                        <label for="theme" class="form-label fw-bold">Tema Warna Website</label>
                        <select class="form-select" id="theme" name="theme">
                            <option value="default" {{ ($setting->theme ?? 'default') == 'default' ? 'selected' : '' }}>Tema Default (Navy & Light Blue)</option>
                            <option value="emerald" {{ ($setting->theme ?? '') == 'emerald' ? 'selected' : '' }}>Tema Emerald (Hijau & Mint)</option>
                            <option value="crimson" {{ ($setting->theme ?? '') == 'crimson' ? 'selected' : '' }}>Tema Crimson (Merah & Oranye)</option>
                            <option value="amethyst" {{ ($setting->theme ?? '') == 'amethyst' ? 'selected' : '' }}>Tema Amethyst (Ungu & Violet)</option>
                            <option value="dark" {{ ($setting->theme ?? '') == 'dark' ? 'selected' : '' }}>Tema Gelap (Sleek Dark Mode)</option>
                        </select>
                        <small class="text-muted">Pilih tema warna utama untuk beranda dan halaman publik portal.</small>
                    </div>

                    <h6 class="fw-bold text-primary mt-4 mb-3"><i class="fa-solid fa-comments me-2"></i> Pengaturan Live Chat WhatsApp</h6>
                    <div class="mb-3">
                        <label for="whatsapp_number" class="form-label fw-bold">Nomor WhatsApp Chat (Format Internasional)</label>
                        <input type="text" class="form-control" id="whatsapp_number" name="whatsapp_number" value="{{ $setting->whatsapp_number }}" placeholder="Contoh: 628123456789">
                        <small class="text-muted">Gunakan kode negara tanpa tanda "+" atau "0" di awal (cth: gunakan 62812... bukan 0812... atau +62812...). Kosongkan jika ingin menonaktifkan widget chat.</small>
                    </div>
                    <div class="mb-3">
                        <label for="whatsapp_welcome_message" class="form-label fw-bold">Pesan Sambutan Live Chat</label>
                        <textarea class="form-control" id="whatsapp_welcome_message" name="whatsapp_welcome_message" rows="3" placeholder="Contoh: Halo! Ada yang bisa kami bantu? Silakan klik tombol di bawah untuk mulai chat via WhatsApp.">{{ $setting->whatsapp_welcome_message }}</textarea>
                        <small class="text-muted">Pesan teks pembuka yang akan tampil di atas tombol chat WhatsApp.</small>
                    </div>

                    <h6 class="fw-bold text-primary mt-4 mb-3"><i class="fa-solid fa-link me-2"></i> Tautan Eksternal & Sosial Media</h6>
                    <div class="mb-3">
                        <label for="external_ppdb_link" class="form-label">Link Pendaftaran PPDB (External)</label>
                        <input type="url" class="form-control" id="external_ppdb_link" name="external_ppdb_link" value="{{ $setting->external_ppdb_link }}" placeholder="https://example.com/ppdb">
                    </div>
                    <div class="mb-3">
                        <label for="facebook_url" class="form-label">URL Facebook</label>
                        <input type="url" class="form-control" id="facebook_url" name="facebook_url" value="{{ $setting->facebook_url }}" placeholder="https://facebook.com/sekolah">
                    </div>
                    <div class="mb-3">
                        <label for="instagram_url" class="form-label">URL Instagram</label>
                        <input type="url" class="form-control" id="instagram_url" name="instagram_url" value="{{ $setting->instagram_url }}" placeholder="https://instagram.com/sekolah">
                    </div>
                    <div class="mb-3">
                        <label for="youtube_url" class="form-label">URL Youtube Channel</label>
                        <input type="url" class="form-control" id="youtube_url" name="youtube_url" value="{{ $setting->youtube_url }}" placeholder="https://youtube.com/c/sekolah">
                    </div>
                </div>

                <!-- Right Column: Visi Misi & Sambutan Kepala Sekolah -->
                <div class="col-md-6">
                    <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-bullseye me-2"></i> Visi & Misi</h6>
                    <div class="mb-3">
                        <label for="vision" class="form-label">Visi Sekolah</label>
                        <textarea class="form-control" id="vision" name="vision" rows="3">{{ $setting->vision }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="mission" class="form-label">Misi Sekolah (Pisahkan dengan baris baru)</label>
                        <textarea class="form-control" id="mission" name="mission" rows="4" placeholder="1. Misi kesatu&#10;2. Misi kedua">{{ $setting->mission }}</textarea>
                    </div>

                    <h6 class="fw-bold text-primary mt-4 mb-3"><i class="fa-solid fa-user me-2"></i> Sambutan Kepala Sekolah</h6>
                    <div class="mb-3">
                        <label for="principal_name" class="form-label">Nama Kepala Sekolah</label>
                        <input type="text" class="form-control" id="principal_name" name="principal_name" value="{{ $setting->principal_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="principal_speech" class="form-label">Naskah Sambutan</label>
                        <textarea class="form-control" id="principal_speech" name="principal_speech" rows="5">{{ $setting->principal_speech }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="principal_photo" class="form-label">Foto Kepala Sekolah</label>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $setting->principal_photo_url }}" alt="Foto Kepala Sekolah" class="img-thumbnail" style="max-height: 80px;" id="principal-preview">
                            <input type="file" class="form-control" id="principal_photo" name="principal_photo" accept="image/*">
                        </div>
                        <small class="text-muted d-block mt-1">Ukuran maks: 2MB, format: PNG, JPG, JPEG</small>
                    </div>
                </div>
            </div>

            <hr class="mt-4 mb-4">
            <h6 class="fw-bold text-primary mb-3"><i class="fa-solid fa-user-plus me-2"></i> Pengaturan Informasi Halaman PPDB</h6>
            <div class="row">
                <div class="col-md-12 mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="ppdb_active" name="ppdb_active" value="1" {{ ($setting->ppdb_active ?? 1) ? 'checked' : '' }}>
                        <label class="form-check-label fw-bold" for="ppdb_active">Tampilkan Halaman / Informasi PPDB</label>
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label for="ppdb_content" class="form-label">Deskripsi Sambutan PPDB</label>
                    <textarea class="form-control" id="ppdb_content" name="ppdb_content" rows="3" placeholder="Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran ini telah dibuka...">{{ $setting->ppdb_content }}</textarea>
                    <small class="text-muted">Jika dikosongkan, akan menggunakan teks bawaan (default).</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="ppdb_requirements" class="form-label">Persyaratan Pendaftaran (Pisahkan dengan baris baru)</label>
                    <textarea class="form-control" id="ppdb_requirements" name="ppdb_requirements" rows="5" placeholder="Mengisi Formulir Pendaftaran&#10;Fotokopi Kartu Keluarga">{{ $setting->ppdb_requirements }}</textarea>
                    <small class="text-muted">Jika dikosongkan, akan menggunakan daftar persyaratan bawaan.</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="ppdb_schedule" class="form-label">Jadwal Pendaftaran (Pisahkan dengan baris baru)</label>
                    <textarea class="form-control" id="ppdb_schedule" name="ppdb_schedule" rows="5" placeholder="Gelombang 1: Januari - Maret&#10;Gelombang 2: April - Mei">{{ $setting->ppdb_schedule }}</textarea>
                    <small class="text-muted">Jika dikosongkan, akan menggunakan jadwal bawaan.</small>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-end border-top pt-3">
                    <button type="submit" class="btn btn-primary px-4"><i class="fa-solid fa-floppy-disk me-2"></i> Simpan Perubahan</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // School logo preview
    $('#school_logo').change(function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#logo-preview').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // Principal photo preview
    $('#principal_photo').change(function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#principal-preview').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });

    // Form submit AJAX
    $('#settings-form').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        Swal.fire({
            title: 'Menyimpan...',
            text: 'Mohon tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ route('admin.settings.update') }}",
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.close();
                if (response.success) {
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
                let errorMsg = 'Terjadi kesalahan sistem.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: errorMsg
                });
            }
        });
    });
});
</script>
@endpush
