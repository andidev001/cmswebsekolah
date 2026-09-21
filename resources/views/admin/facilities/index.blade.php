@extends('layouts.admin')

@section('title', 'Fasilitas Sekolah')
@section('page-title', 'Manajemen Fasilitas Sekolah')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-building me-2 text-primary"></i> Daftar Fasilitas</h5>
        <button type="button" class="btn btn-primary btn-sm" id="create-btn">
            <i class="fa-solid fa-plus me-1"></i> Tambah Fasilitas
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="facilities-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Foto</th>
                        <th>Nama Fasilitas</th>
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
<!-- Facility Modal -->
<div class="modal fade" id="facility-modal" tabindex="-1" aria-labelledby="facilityModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="facilityModalLabel">Form Fasilitas</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="facility-form" enctype="multipart/form-data">
                <input type="hidden" id="facility-id" name="facility_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="facility_name" class="form-label">Nama Fasilitas</label>
                        <input type="text" class="form-control" id="facility_name" name="name" placeholder="Contoh: Perpustakaan / Lab Komputer" required>
                    </div>

                    <div class="mb-3">
                        <label for="facility_desc" class="form-label">Keterangan / Deskripsi</label>
                        <textarea class="form-control" id="facility_desc" name="description" rows="4" placeholder="Masukkan deskripsi fasilitas..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="facility_photo" class="form-label">Foto Fasilitas</label>
                        <input type="file" class="form-control" id="facility_photo" name="photo" accept="image/*">
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
    let table = $('#facilities-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.facilities.data') }}",
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
            { data: 'description', name: 'description' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });

    // Reset Form Modal
    function resetForm() {
        $('#facility-form')[0].reset();
        $('#facility-id').val('');
        $('#current-photo-container').hide();
        $('#current-photo-preview').attr('src', '');
        $('#facilityModalLabel').text('Tambah Fasilitas');
        $('#save-btn').text('Simpan');
    }

    // Open Modal for Create
    $('#create-btn').on('click', function() {
        resetForm();
        $('#facility-modal').modal('show');
    });

    // Handle Form Submit
    $('#facility-form').on('submit', function(e) {
        e.preventDefault();

        let id = $('#facility-id').val();
        let url = id ? "{{ url('admin/facilities/update') }}/" + id : "{{ route('admin.facilities.store') }}";
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
                    $('#facility-modal').modal('hide');
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
            url: "{{ url('admin/facilities/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#facility-id').val(response.id);
                $('#facility_name').val(response.name);
                $('#facility_desc').val(response.description);

                if (response.photo_url) {
                    $('#current-photo-preview').attr('src', response.photo_url);
                    $('#current-photo-container').show();
                }

                $('#facilityModalLabel').text('Edit Fasilitas');
                $('#save-btn').text('Perbarui');
                $('#facility-modal').modal('show');
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
            text: "Data fasilitas yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea5455',
            cancelButtonColor: '#a8aaae',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/facilities/destroy') }}/" + id,
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
