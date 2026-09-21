@extends('layouts.admin')

@section('title', 'Agenda Kegiatan')
@section('page-title', 'Manajemen Agenda Kegiatan')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-calendar-days me-2 text-primary"></i> Daftar Agenda</h5>
        <button type="button" class="btn btn-primary btn-sm" id="create-btn">
            <i class="fa-solid fa-plus me-1"></i> Tambah Agenda
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="agendas-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Agenda Kegiatan</th>
                        <th>Tanggal Pelaksanaan</th>
                        <th>Waktu</th>
                        <th>Tempat</th>
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
<!-- Agenda Modal -->
<div class="modal fade" id="agenda-modal" tabindex="-1" aria-labelledby="agendaModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="agendaModalLabel">Form Agenda Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="agenda-form">
                <input type="hidden" id="agenda-id" name="agenda_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="agenda_title" class="form-label">Nama Kegiatan</label>
                        <input type="text" class="form-control" id="agenda_title" name="title" placeholder="Contoh: Rapat Wali Murid / Ujian PAS Genap" required>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="agenda_date" class="form-label">Tanggal Pelaksanaan</label>
                            <input type="date" class="form-control" id="agenda_date" name="date" required value="{{ date('Y-m-d') }}">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="agenda_time" class="form-label">Waktu Pelaksanaan</label>
                            <input type="text" class="form-control" id="agenda_time" name="time" placeholder="Contoh: 08:00 WIB - Selesai" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="agenda_location" class="form-label">Tempat Pelaksanaan</label>
                        <input type="text" class="form-control" id="agenda_location" name="location" placeholder="Contoh: Lapangan Utama / Ruang Guru" required>
                    </div>

                    <div class="mb-3">
                        <label for="agenda_desc" class="form-label">Deskripsi / Keterangan Tambahan</label>
                        <textarea class="form-control" id="agenda_desc" name="description" rows="3" placeholder="Masukkan keterangan tambahan jika ada..."></textarea>
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
    let table = $('#agendas-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.agendas.data') }}",
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
            { data: 'date', name: 'date' },
            { data: 'time', name: 'time', defaultContent: '-' },
            { data: 'location', name: 'location', defaultContent: '-' },
            { data: 'description', name: 'description', defaultContent: '-' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });

    // Reset Form Modal
    function resetForm() {
        $('#agenda-form')[0].reset();
        $('#agenda-id').val('');
        $('#agenda_date').val("{{ date('Y-m-d') }}");
        $('#agendaModalLabel').text('Tambah Agenda Kegiatan');
        $('#save-btn').text('Simpan');
    }

    // Open Modal for Create
    $('#create-btn').on('click', function() {
        resetForm();
        $('#agenda-modal').modal('show');
    });

    // Handle Form Submit
    $('#agenda-form').on('submit', function(e) {
        e.preventDefault();

        let id = $('#agenda-id').val();
        let url = id ? "{{ url('admin/agendas/update') }}/" + id : "{{ route('admin.agendas.store') }}";
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
                    $('#agenda-modal').modal('hide');
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
            url: "{{ url('admin/agendas/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#agenda-id').val(response.id);
                $('#agenda_title').val(response.title);
                $('#agenda_date').val(response.date_formatted);
                $('#agenda_time').val(response.time);
                $('#agenda_location').val(response.location);
                $('#agenda_desc').val(response.description);

                $('#agendaModalLabel').text('Edit Agenda Kegiatan');
                $('#save-btn').text('Perbarui');
                $('#agenda-modal').modal('show');
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
            text: "Agenda yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea5455',
            cancelButtonColor: '#a8aaae',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/agendas/destroy') }}/" + id,
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
