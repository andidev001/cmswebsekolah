@extends('layouts.admin')

@section('title', 'Prestasi Siswa')
@section('page-title', 'Manajemen Prestasi Siswa')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-trophy me-2 text-primary"></i> Daftar Prestasi Siswa</h5>
        <button type="button" class="btn btn-primary btn-sm" id="create-btn">
            <i class="fa-solid fa-plus me-1"></i> Tambah Prestasi
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="achievements-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Foto</th>
                        <th>Prestasi / Penghargaan</th>
                        <th>Nama Siswa / Tim</th>
                        <th>Tanggal</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('modals')
<!-- Achievement Modal -->
<div class="modal fade" id="achievement-modal" tabindex="-1" aria-labelledby="achievementModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="achievementModalLabel">Form Prestasi Siswa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="achievement-form" enctype="multipart/form-data">
                <input type="hidden" id="achievement-id" name="achievement_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="achievement_title" class="form-label">Prestasi / Kejuaraan yang Diraih</label>
                        <input type="text" class="form-control" id="achievement_title" name="title" placeholder="Contoh: Juara 1 LKS Tingkat Kabupaten" required>
                    </div>

                    <div class="mb-3">
                        <label for="student_name" class="form-label">Nama Siswa / Kelompok Siswa</label>
                        <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Contoh: Ahmad Fauzi / Tim Futsal" required>
                    </div>

                    <div class="mb-3">
                        <label for="achievement_date" class="form-label">Tanggal Penghargaan</label>
                        <input type="date" class="form-control" id="achievement_date" name="date" required value="{{ date('Y-m-d') }}">
                    </div>

                    <div class="mb-3">
                        <label for="achievement_desc" class="form-label">Deskripsi / Detail Penghargaan</label>
                        <textarea class="form-control" id="achievement_desc" name="description" rows="3" placeholder="Masukkan keterangan detail prestasi..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="achievement_photo" class="form-label">Foto Penerimaan / Penyerahan</label>
                        <input type="file" class="form-control" id="achievement_photo" name="photo" accept="image/*">
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
    let table = $('#achievements-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.achievements.data') }}",
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
            { data: 'title', name: 'title' },
            { data: 'student_name', name: 'student_name', defaultContent: '-' },
            { data: 'date', name: 'date' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });

    // Reset Form Modal
    function resetForm() {
        $('#achievement-form')[0].reset();
        $('#achievement-id').val('');
        $('#current-photo-container').hide();
        $('#current-photo-preview').attr('src', '');
        $('#achievement_date').val("{{ date('Y-m-d') }}");
        $('#achievementModalLabel').text('Tambah Prestasi Siswa');
        $('#save-btn').text('Simpan');
    }

    // Open Modal for Create
    $('#create-btn').on('click', function() {
        resetForm();
        $('#achievement-modal').modal('show');
    });

    // Handle Form Submit
    $('#achievement-form').on('submit', function(e) {
        e.preventDefault();

        let id = $('#achievement-id').val();
        let url = id ? "{{ url('admin/achievements/update') }}/" + id : "{{ route('admin.achievements.store') }}";
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
                    $('#achievement-modal').modal('hide');
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
            url: "{{ url('admin/achievements/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#achievement-id').val(response.id);
                $('#achievement_title').val(response.title);
                $('#student_name').val(response.student_name);
                $('#achievement_date').val(response.date_formatted);
                $('#achievement_desc').val(response.description);

                if (response.photo_url) {
                    $('#current-photo-preview').attr('src', response.photo_url);
                    $('#current-photo-container').show();
                }

                $('#achievementModalLabel').text('Edit Prestasi Siswa');
                $('#save-btn').text('Perbarui');
                $('#achievement-modal').modal('show');
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
            text: "Data prestasi yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea5455',
            cancelButtonColor: '#a8aaae',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/achievements/destroy') }}/" + id,
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
