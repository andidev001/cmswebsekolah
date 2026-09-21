@extends('layouts.admin')

@section('title', 'Ekstrakurikuler')
@section('page-title', 'Manajemen Ekstrakurikuler')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-volleyball me-2 text-primary"></i> Daftar Ekstrakurikuler</h5>
        <button type="button" class="btn btn-primary btn-sm" id="create-btn">
            <i class="fa-solid fa-plus me-1"></i> Tambah Ekskul
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="ekskuls-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Foto</th>
                        <th>Nama Ekskul</th>
                        <th>Pembina Ekskul</th>
                        <th>Keterangan</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('modals')
<!-- Ekskul Modal -->
<div class="modal fade" id="ekskul-modal" tabindex="-1" aria-labelledby="ekskulModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ekskulModalLabel">Form Ekstrakurikuler</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="ekskul-form" enctype="multipart/form-data">
                <input type="hidden" id="ekskul-id" name="ekskul_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ekskul_name" class="form-label">Nama Ekstrakurikuler</label>
                        <input type="text" class="form-control" id="ekskul_name" name="name" placeholder="Contoh: Paskibra / Pramuka / Futsal" required>
                    </div>

                    <div class="mb-3">
                        <label for="ekskul_coach" class="form-label">Nama Pembina</label>
                        <input type="text" class="form-control" id="ekskul_coach" name="coach" placeholder="Contoh: Budi Santoso, S.Pd." required>
                    </div>

                    <div class="mb-3">
                        <label for="ekskul_desc" class="form-label">Keterangan / Kegiatan</label>
                        <textarea class="form-control" id="ekskul_desc" name="description" rows="4" placeholder="Masukkan deskripsi kegiatan ekskul..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="ekskul_photo" class="form-label">Foto Kegiatan</label>
                        <input type="file" class="form-control" id="ekskul_photo" name="photo" accept="image/*">
                        <small class="text-muted">Maksimal 2MB, format: JPG, JPEG, PNG</small>
                        <div class="mt-2" id="current-photo-container" style="display: none;">
                            <small class="text-muted d-block">Foto Saat Ini:</small>
                            <img src="" alt="Foto" class="img-thumbnail" id="current-photo-preview" style="max-height: 100px;">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
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
    let table = $('#ekskuls-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.extracurriculars.data') }}",
        columns: [
            {
                data: null,
                searchable: false,
                orderable: false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'photo_preview', name: 'photo_preview', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'coach', name: 'coach', defaultContent: '-' },
            { data: 'description', name: 'description' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });

    // Reset Form Modal
    function resetForm() {
        $('#ekskul-form')[0].reset();
        $('#ekskul-id').val('');
        $('#current-photo-container').hide();
        $('#current-photo-preview').attr('src', '');
        $('#ekskulModalLabel').text('Tambah Ekstrakurikuler');
        $('#save-btn').text('Simpan');
    }

    // Open Modal for Create
    $('#create-btn').on('click', function() {
        resetForm();
        $('#ekskul-modal').modal('show');
    });

    // Handle Form Submit
    $('#ekskul-form').on('submit', function(e) {
        e.preventDefault();

        let id = $('#ekskul-id').val();
        let url = id ? "{{ url('admin/extracurriculars/update') }}/" + id : "{{ route('admin.extracurriculars.store') }}";
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
                    $('#ekskul-modal').modal('hide');
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

        $.ajax({
            url: "{{ url('admin/extracurriculars/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#ekskul-id').val(response.id);
                $('#ekskul_name').val(response.name);
                $('#ekskul_coach').val(response.coach);
                $('#ekskul_desc').val(response.description);

                if (response.photo_url) {
                    $('#current-photo-preview').attr('src', response.photo_url);
                    $('#current-photo-container').show();
                }

                $('#ekskulModalLabel').text('Edit Ekstrakurikuler');
                $('#save-btn').text('Perbarui');
                $('#ekskul-modal').modal('show');
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
            text: "Data ekskul yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea5455',
            cancelButtonColor: '#a8aaae',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/extracurriculars/destroy') }}/" + id,
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
