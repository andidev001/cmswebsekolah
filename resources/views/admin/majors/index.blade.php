@extends('layouts.admin')

@section('title', 'Jurusan & Program Keahlian')
@section('page-title', 'Manajemen Jurusan & Program Keahlian')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-graduation-cap me-2 text-primary"></i> Daftar Jurusan & Program Keahlian</h5>
        <button type="button" class="btn btn-primary btn-sm" id="create-btn">
            <i class="fa-solid fa-plus me-1"></i> Tambah Jurusan
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="majors-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Foto</th>
                        <th>Nama Jurusan</th>
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
<!-- Major Modal -->
<div class="modal fade" id="major-modal" tabindex="-1" aria-labelledby="majorModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="majorModalLabel">Form Jurusan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="major-form" enctype="multipart/form-data">
                <input type="hidden" id="major-id" name="major_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="major_name" class="form-label">Nama Jurusan / Program Keahlian</label>
                        <input type="text" class="form-control" id="major_name" name="name" placeholder="Contoh: Rekayasa Perangkat Lunak / MIPA" required>
                    </div>

                    <div class="mb-3">
                        <label for="major_desc" class="form-label">Keterangan / Deskripsi Jurusan</label>
                        <textarea class="form-control" id="major_desc" name="description" rows="4" placeholder="Masukkan deskripsi jurusan..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="major_photo" class="form-label">Foto / Banner Jurusan</label>
                        <input type="file" class="form-control" id="major_photo" name="photo" accept="image/*">
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
    let table = $('#majors-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.majors.data') }}",
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
        $('#major-form')[0].reset();
        $('#major-id').val('');
        $('#current-photo-container').hide();
        $('#current-photo-preview').attr('src', '');
        $('#majorModalLabel').text('Tambah Jurusan / Program Keahlian');
        $('#save-btn').text('Simpan');
    }

    // Open Modal for Create
    $('#create-btn').on('click', function() {
        resetForm();
        $('#major-modal').modal('show');
    });

    // Handle Form Submit
    $('#major-form').on('submit', function(e) {
        e.preventDefault();

        let id = $('#major-id').val();
        let url = id ? "{{ url('admin/majors/update') }}/" + id : "{{ route('admin.majors.store') }}";
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
                    $('#major-modal').modal('hide');
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
            url: "{{ url('admin/majors/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#major-id').val(response.id);
                $('#major_name').val(response.name);
                $('#major_desc').val(response.description);

                if (response.photo_url) {
                    $('#current-photo-preview').attr('src', response.photo_url);
                    $('#current-photo-container').show();
                }

                $('#majorModalLabel').text('Edit Jurusan / Program Keahlian');
                $('#save-btn').text('Perbarui');
                $('#major-modal').modal('show');
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
            text: "Data jurusan yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea5455',
            cancelButtonColor: '#a8aaae',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/majors/destroy') }}/" + id,
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
