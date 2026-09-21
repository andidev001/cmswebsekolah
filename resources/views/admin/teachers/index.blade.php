@extends('layouts.admin')

@section('title', 'Data Guru & Staff')
@section('page-title', 'Manajemen Data Guru & Staff')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-user-tie me-2 text-primary"></i> Daftar Guru & Staff</h5>
        <button type="button" class="btn btn-primary btn-sm" id="create-btn">
            <i class="fa-solid fa-plus me-1"></i> Tambah Guru/Staff
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="teachers-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Foto</th>
                        <th>NIP</th>
                        <th>Nama Lengkap</th>
                        <th>Jabatan / Mata Pelajaran</th>
                        <th>Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('modals')
<!-- Teacher Modal -->
<div class="modal fade" id="teacher-modal" tabindex="-1" aria-labelledby="teacherModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="teacherModalLabel">Form Guru & Staff</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="teacher-form" enctype="multipart/form-data">
                <input type="hidden" id="teacher-id" name="teacher_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="teacher_name" class="form-label">Nama Lengkap (Beserta Gelar)</label>
                        <input type="text" class="form-control" id="teacher_name" name="name" placeholder="Contoh: Ahmad Subarjo, S.Kom." required>
                    </div>

                    <div class="mb-3">
                        <label for="teacher_nip" class="form-label">NIP (Kosongkan jika tidak ada)</label>
                        <input type="text" class="form-control" id="teacher_nip" name="nip" placeholder="Contoh: 19880412...">
                    </div>

                    <div class="mb-3">
                        <label for="teacher_position" class="form-label">Jabatan / Mata Pelajaran</label>
                        <input type="text" class="form-control" id="teacher_position" name="position" placeholder="Contoh: Guru Matematika / Kepala Sekolah" required>
                    </div>

                    <div class="mb-3">
                        <label for="teacher_photo" class="form-label">Foto Profil</label>
                        <input type="file" class="form-control" id="teacher_photo" name="photo" accept="image/*">
                        <small class="text-muted">Maksimal 2MB, format: JPG, JPEG, PNG</small>
                        <div class="mt-2" id="current-photo-container" style="display: none;">
                            <small class="text-muted d-block">Foto Saat Ini:</small>
                            <img src="" alt="Foto" class="img-thumbnail rounded-circle" id="current-photo-preview" style="width: 80px; height: 80px; object-fit: cover;">
                        </div>
                    </div>

                    <div class="mb-3 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="teacher_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="teacher_active">Status Aktif</label>
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
    let table = $('#teachers-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.teachers.data') }}",
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
            { data: 'nip', name: 'nip', defaultContent: '-' },
            { data: 'name', name: 'name' },
            { data: 'position', name: 'position' },
            { data: 'is_active', name: 'is_active' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });

    // Reset Form Modal
    function resetForm() {
        $('#teacher-form')[0].reset();
        $('#teacher-id').val('');
        $('#current-photo-container').hide();
        $('#current-photo-preview').attr('src', '');
        $('#teacher_active').prop('checked', true);
        $('#teacherModalLabel').text('Tambah Guru & Staff');
        $('#save-btn').text('Simpan');
    }

    // Open Modal for Create
    $('#create-btn').on('click', function() {
        resetForm();
        $('#teacher-modal').modal('show');
    });

    // Handle Form Submit
    $('#teacher-form').on('submit', function(e) {
        e.preventDefault();

        let id = $('#teacher-id').val();
        let url = id ? "{{ url('admin/teachers/update') }}/" + id : "{{ route('admin.teachers.store') }}";
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
                    $('#teacher-modal').modal('hide');
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
            url: "{{ url('admin/teachers/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#teacher-id').val(response.id);
                $('#teacher_name').val(response.name);
                $('#teacher_nip').val(response.nip);
                $('#teacher_position').val(response.position);
                $('#teacher_active').prop('checked', response.is_active);

                if (response.photo_url) {
                    $('#current-photo-preview').attr('src', response.photo_url);
                    $('#current-photo-container').show();
                }

                $('#teacherModalLabel').text('Edit Guru & Staff');
                $('#save-btn').text('Perbarui');
                $('#teacher-modal').modal('show');
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
            text: "Data guru yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea5455',
            cancelButtonColor: '#a8aaae',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/teachers/destroy') }}/" + id,
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
