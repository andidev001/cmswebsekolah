@extends('layouts.admin')

@section('title', 'Pengumuman Sekolah')
@section('page-title', 'Manajemen Pengumuman')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-bullhorn me-2 text-primary"></i> Daftar Pengumuman</h5>
        <button type="button" class="btn btn-primary btn-sm" id="create-btn">
            <i class="fa-solid fa-plus me-1"></i> Tambah Pengumuman
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="announcements-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Judul Pengumuman</th>
                        <th>Isi Singkat</th>
                        <th>Tanggal Publish</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('modals')
<!-- Announcement Modal -->
<div class="modal fade" id="announcement-modal" tabindex="-1" aria-labelledby="announcementModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="announcementModalLabel">Form Pengumuman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="announcement-form">
                <input type="hidden" id="announcement-id" name="announcement_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="announcement_title" class="form-label">Judul Pengumuman</label>
                        <input type="text" class="form-control" id="announcement_title" name="title" placeholder="Masukkan judul pengumuman" required>
                    </div>

                    <div class="mb-3">
                        <label for="announcement_date" class="form-label">Tanggal Publish</label>
                        <input type="date" class="form-control" id="announcement_date" name="date" required value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label for="announcement_content" class="form-label">Isi / Pengumuman Lengkap</label>
                        <textarea class="form-control" id="announcement_content" name="content" rows="6" placeholder="Tulis isi pengumuman di sini..." required></textarea>
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
    let table = $('#announcements-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.announcements.data') }}",
        columns: [
            {
                data: null,
                searchable: false,
                orderable: false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'title', name: 'title' },
            { data: 'content', name: 'content' },
            { data: 'date', name: 'date' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });

    // Reset Form Modal
    function resetForm() {
        $('#announcement-form')[0].reset();
        $('#announcement-id').val('');
        $('#announcement_date').val("{{ date('Y-m-d') }}");
        $('#announcementModalLabel').text('Tambah Pengumuman');
        $('#save-btn').text('Simpan');
    }

    // Open Modal for Create
    $('#create-btn').on('click', function() {
        resetForm();
        $('#announcement-modal').modal('show');
    });

    // Handle Form Submit
    $('#announcement-form').on('submit', function(e) {
        e.preventDefault();

        let id = $('#announcement-id').val();
        let url = id ? "{{ url('admin/announcements/update') }}/" + id : "{{ route('admin.announcements.store') }}";
        let data = $(this).serialize();

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
            data: data,
            success: function(response) {
                Swal.close();
                if(response.success) {
                    $('#announcement-modal').modal('hide');
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
            url: "{{ url('admin/announcements/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#announcement-id').val(response.id);
                $('#announcement_title').val(response.title);
                $('#announcement_date').val(response.date_formatted);
                $('#announcement_content').val(response.content);

                $('#announcementModalLabel').text('Edit Pengumuman');
                $('#save-btn').text('Perbarui');
                $('#announcement-modal').modal('show');
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
            text: "Pengumuman yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea5455',
            cancelButtonColor: '#a8aaae',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/announcements/destroy') }}/" + id,
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
