@extends('layouts.admin')

@section('title', 'Slider Beranda')
@section('page-title', 'Manajemen Slider Beranda (Hero Carousel)')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-images me-2 text-primary"></i> Daftar Slide Hero</h5>
        <button type="button" class="btn btn-primary btn-sm" id="create-btn">
            <i class="fa-solid fa-plus me-1"></i> Tambah Slide
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="carousel-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th width="150">Gambar</th>
                        <th>Judul Utama</th>
                        <th>Sub-Judul / Deskripsi</th>
                        <th>Tombol Aksi</th>
                        <th width="80">Urutan</th>
                        <th width="100">Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('modals')
<!-- Carousel Modal -->
<div class="modal fade" id="carousel-modal" tabindex="-1" aria-labelledby="carouselModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="carouselModalLabel">Form Slide Hero</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="carousel-form" enctype="multipart/form-data">
                <input type="hidden" id="carousel-id" name="carousel_id">
                <div class="modal-body">
                    <div class="row">
                        <!-- Kolom Kiri: Gambar dan Preview -->
                        <div class="col-md-5 mb-3 border-end">
                            <div class="mb-3">
                                <label for="carousel_image" class="form-label fw-semibold">Gambar Slide <span class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="carousel_image" name="image" accept="image/*">
                                <small class="text-muted d-block mt-1">Ukuran ideal: 1920x1080 px atau rasio 16:9. Maks 3MB, format: JPG, JPEG, PNG, WEBP</small>
                            </div>
                            
                            <div class="card bg-light text-center p-2" id="preview-card" style="min-height: 180px; display: flex; align-items: center; justify-content: center;">
                                <div id="preview-placeholder">
                                    <i class="fa-regular fa-image display-4 text-muted mb-2"></i>
                                    <p class="text-muted small m-0">Pratinjau Gambar</p>
                                </div>
                                <img src="" alt="Pratinjau" class="img-fluid rounded shadow-sm" id="image-preview" style="display: none; max-height: 200px; object-fit: cover;">
                            </div>
                        </div>

                        <!-- Kolom Kanan: Teks & Pengaturan -->
                        <div class="col-md-7 mb-3">
                            <div class="mb-3">
                                <label for="carousel_title" class="form-label fw-semibold">Judul Slide (Opsional)</label>
                                <input type="text" class="form-control" id="carousel_title" name="title" placeholder="Contoh: Selamat Datang di {{ $adminSettings->school_name ?? 'Sekolah' }}">
                            </div>

                            <div class="mb-3">
                                <label for="carousel_subtitle" class="form-label fw-semibold">Sub-Judul / Deskripsi Singkat</label>
                                <textarea class="form-control" id="carousel_subtitle" name="subtitle" rows="3" placeholder="Tulis deskripsi singkat yang tampil di bawah judul..."></textarea>
                            </div>

                            <div class="row">
                                <div class="col-sm-6 mb-3">
                                    <label for="carousel_btn_text" class="form-label fw-semibold">Teks Tombol (Opsional)</label>
                                    <input type="text" class="form-control" id="carousel_btn_text" name="button_text" placeholder="Contoh: Selengkapnya">
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <label for="carousel_btn_link" class="form-label fw-semibold">Link Tombol (Opsional)</label>
                                    <input type="url" class="form-control" id="carousel_btn_link" name="button_link" placeholder="https://example.com/page">
                                </div>
                            </div>

                            <div class="row align-items-center mt-2">
                                <div class="col-sm-6 mb-3">
                                    <label for="carousel_order" class="form-label fw-semibold">Urutan Tampil</label>
                                    <input type="number" class="form-control" id="carousel_order" name="order_index" value="0" min="0" required>
                                    <small class="text-muted">Semakin kecil, tampil semakin awal</small>
                                </div>
                                <div class="col-sm-6 mb-3">
                                    <div class="form-check form-switch mt-4 ps-5">
                                        <input class="form-check-input" type="checkbox" id="carousel_active" name="is_active" value="1" checked style="width: 2.5em; height: 1.25em; cursor: pointer;">
                                        <label class="form-check-label fw-semibold ms-2" for="carousel_active" style="cursor: pointer;">Tampilkan Slide</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top pt-3">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="save-btn">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Datatable
    let table = $('#carousel-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.carousels.data') }}",
        columns: [
            {
                data: null,
                searchable: false,
                orderable: false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { 
                data: 'image_url', 
                name: 'image', 
                orderable: false, 
                searchable: false,
                render: function(data) {
                    return `<img src="${data}" alt="Slide" class="img-thumbnail rounded" style="max-height: 70px; object-fit: cover;">`;
                }
            },
            { data: 'title', name: 'title', defaultContent: '<span class="text-muted">Tanpa Judul</span>' },
            { 
                data: 'subtitle', 
                name: 'subtitle', 
                defaultContent: '-', 
                render: function(data){ 
                    return data && data.length > 60 ? data.substr(0, 60) + '...' : (data || '-'); 
                } 
            },
            { 
                data: null, 
                orderable: false,
                searchable: false,
                render: function(data, type, row) {
                    if (row.button_text && row.button_link) {
                        return `<a href="${row.button_link}" target="_blank" class="badge bg-primary text-decoration-none">${row.button_text} <i class="fa-solid fa-up-right-from-square ms-1" style="font-size:0.7rem;"></i></a>`;
                    }
                    return '<span class="text-muted">-</span>';
                }
            },
            { data: 'order_index', name: 'order_index', className: 'text-center' },
            { 
                data: 'is_active', 
                name: 'is_active', 
                className: 'text-center',
                render: function(data) {
                    if (data) {
                        return '<span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i> Aktif</span>';
                    }
                    return '<span class="badge bg-secondary"><i class="fa-solid fa-circle-minus me-1"></i> Nonaktif</span>';
                }
            },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });

    // Image Upload Live Preview
    $('#carousel_image').change(function() {
        const file = this.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(event) {
                $('#image-preview').attr('src', event.target.result).show();
                $('#preview-placeholder').hide();
            }
            reader.readAsDataURL(file);
        }
    });

    // Reset Form Modal
    function resetForm() {
        $('#carousel-form')[0].reset();
        $('#carousel-id').val('');
        $('#image-preview').hide().attr('src', '');
        $('#preview-placeholder').show();
        $('#carousel_active').prop('checked', true);
        $('#carouselModalLabel').text('Tambah Slide Hero');
        $('#save-btn').text('Simpan');
        $('#carousel_image').prop('required', true); // Diperlukan saat buat baru
    }

    // Open Modal for Create
    $('#create-btn').on('click', function() {
        resetForm();
        $('#carousel-modal').modal('show');
    });

    // Handle Form Submit
    $('#carousel-form').on('submit', function(e) {
        e.preventDefault();

        let id = $('#carousel-id').val();
        let url = id ? "{{ url('admin/carousels/update') }}/" + id : "{{ route('admin.carousels.store') }}";
        let formData = new FormData(this);

        Swal.fire({
            title: 'Memproses...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.close();
                if(response.success) {
                    $('#carousel-modal').modal('hide');
                    table.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
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

    // Handle Edit Button
    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        resetForm();
        $('#carousel_image').prop('required', false); // Tidak wajib pas edit

        $.ajax({
            url: "{{ url('admin/carousels/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#carousel-id').val(response.id);
                $('#carousel_title').val(response.title);
                $('#carousel_subtitle').val(response.subtitle);
                $('#carousel_btn_text').val(response.button_text);
                $('#carousel_btn_link').val(response.button_link);
                $('#carousel_order').val(response.order_index);
                
                $('#carousel_active').prop('checked', response.is_active ? true : false);

                if (response.image_url) {
                    $('#image-preview').attr('src', response.image_url).show();
                    $('#preview-placeholder').hide();
                }

                $('#carouselModalLabel').text('Edit Slide Hero');
                $('#save-btn').text('Perbarui');
                $('#carousel-modal').modal('show');
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Gagal mengambil data dari server.'
                });
            }
        });
    });

    // Handle Delete Button
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Slide yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea5455',
            cancelButtonColor: '#a8aaae',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/carousels/destroy') }}/" + id,
                    type: "DELETE",
                    success: function(response) {
                        if(response.success) {
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Terhapus!',
                                text: response.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: 'Gagal menghapus data.'
                        });
                    }
                });
            }
        });
    });
});
</script>
@endpush
