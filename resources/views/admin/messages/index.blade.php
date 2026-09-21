@extends('layouts.admin')

@section('title', 'Pesan Hubungi Kami')
@section('page-title', 'Pesan Masuk (Hubungi Kami)')

@section('content')
<div class="card">
    <div class="card-header border-bottom py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-envelope-open-text me-2 text-primary"></i> Daftar Pesan Masuk</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="messages-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Pengirim</th>
                        <th>Email</th>
                        <th>Subjek</th>
                        <th>Tanggal Masuk</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('modals')
<!-- Message View Modal -->
<div class="modal fade" id="message-modal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="messageModalLabel"><i class="fa-regular fa-envelope me-2 text-primary"></i> Detail Pesan Masuk</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3 border-bottom pb-2">
                    <span class="text-muted d-block" style="font-size: 0.8rem; font-weight: 500;">PENGIRIM</span>
                    <strong class="text-dark" id="msg-name"></strong>
                </div>
                <div class="mb-3 border-bottom pb-2">
                    <span class="text-muted d-block" style="font-size: 0.8rem; font-weight: 500;">EMAIL</span>
                    <span id="msg-email"></span>
                </div>
                <div class="mb-3 border-bottom pb-2">
                    <span class="text-muted d-block" style="font-size: 0.8rem; font-weight: 500;">TANGGAL KIRIM</span>
                    <span id="msg-date"></span>
                </div>
                <div class="mb-3 border-bottom pb-2">
                    <span class="text-muted d-block" style="font-size: 0.8rem; font-weight: 500;">SUBJEK</span>
                    <strong class="text-dark" id="msg-subject"></strong>
                </div>
                <div class="mb-2">
                    <span class="text-muted d-block mb-1" style="font-size: 0.8rem; font-weight: 500;">PESAN / ISI</span>
                    <div class="bg-light p-3 rounded" id="msg-content" style="white-space: pre-line; font-size: 0.9rem; line-height: 1.5; color: #4b4b4b;"></div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Datatable
    let table = $('#messages-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.messages.data') }}",
        columns: [
            {
                data: null,
                searchable: false,
                orderable: false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'subject', name: 'subject', defaultContent: 'Tanpa Subjek' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });

    // Handle View Button
    $(document).on('click', '.view-btn', function() {
        let id = $(this).data('id');

        $.ajax({
            url: "{{ url('admin/messages/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#msg-name').text(response.name);
                $('#msg-email').text(response.email);
                $('#msg-date').text(response.date_formatted);
                $('#msg-subject').text(response.subject || 'Tanpa Subjek');
                $('#msg-content').text(response.message);
                
                $('#message-modal').modal('show');
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
            text: "Pesan yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea5455',
            cancelButtonColor: '#a8aaae',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/messages/destroy') }}/" + id,
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
