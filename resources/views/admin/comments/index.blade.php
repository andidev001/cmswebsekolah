@extends('layouts.admin')

@section('title', 'Manajemen Komentar')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Komentar</h1>
    </div>

    <div class="card shadow mb-4 border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="comments-table" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Artikel</th>
                            <th width="15%">Nama</th>
                            <th width="40%">Komentar</th>
                            <th width="10%">Status</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Reply Modal -->
<div class="modal fade" id="reply-modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="reply-form">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title">Balas & Setujui Komentar</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="reply-comment-id" name="id">
                    
                    <div class="mb-3">
                        <label class="form-label text-muted small mb-0">Komentar Pengguna:</label>
                        <div class="p-2 bg-light rounded border" id="user-comment-text" style="font-size: 0.9rem;"></div>
                    </div>

                    <div class="mb-3">
                        <label for="admin_reply" class="form-label">Balasan Admin</label>
                        <textarea class="form-control" id="admin_reply" name="admin_reply" rows="4" placeholder="Ketik balasan Anda di sini... (opsional)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-info text-white" id="reply-submit-btn">Simpan Balasan & Setujui</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let table = $('#comments-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.comments.data') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'post_title', name: 'post.title'},
            {data: 'name', name: 'name'},
            {data: 'body', name: 'body'},
            {data: 'status', name: 'is_approved', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    $(document).on('click', '.toggle-btn', function() {
        let id = $(this).data('id');
        let isApproveBtn = $(this).hasClass('btn-success');
        
        if (isApproveBtn) {
            // Open reply modal directly instead of just toggling
            $.ajax({
                url: "{{ url('admin/comments/show') }}/" + id,
                type: "GET",
                success: function(response) {
                    $('#reply-comment-id').val(response.id);
                    $('#user-comment-text').text(response.body);
                    $('#admin_reply').val(response.admin_reply);
                    $('#reply-modal').modal('show');
                },
                error: function() {
                    Swal.fire('Error', 'Data tidak ditemukan.', 'error');
                }
            });
        } else {
            // Hide action (un-approve)
            $.ajax({
                url: "{{ url('admin/comments/toggle-approve') }}/" + id,
                type: "POST",
                success: function(response) {
                    if(response.success) {
                        Swal.fire({
                            toast: true, position: 'top-end', icon: 'success',
                            title: response.message, showConfirmButton: false, timer: 1500
                        });
                        table.ajax.reload(null, false);
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Terjadi kesalahan sistem.', 'error');
                }
            });
        }
    });

    $(document).on('click', '.reply-btn', function() {
        let id = $(this).data('id');
        $.ajax({
            url: "{{ url('admin/comments/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#reply-comment-id').val(response.id);
                $('#user-comment-text').text(response.body);
                $('#admin_reply').val(response.admin_reply);
                $('#reply-modal').modal('show');
            },
            error: function() {
                Swal.fire('Error', 'Data tidak ditemukan.', 'error');
            }
        });
    });

    $('#reply-form').submit(function(e) {
        e.preventDefault();
        let id = $('#reply-comment-id').val();
        let submitBtn = $('#reply-submit-btn');
        submitBtn.prop('disabled', true).text('Menyimpan...');

        $.ajax({
            url: "{{ url('admin/comments/reply') }}/" + id,
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                submitBtn.prop('disabled', false).text('Simpan Balasan & Setujui');
                if(response.success) {
                    $('#reply-modal').modal('hide');
                    Swal.fire('Berhasil!', response.message, 'success');
                    table.ajax.reload(null, false);
                }
            },
            error: function() {
                submitBtn.prop('disabled', false).text('Simpan Balasan & Setujui');
                Swal.fire('Error', 'Terjadi kesalahan saat membalas komentar.', 'error');
            }
        });
    });

    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Komentar ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/comments/destroy') }}/" + id,
                    type: "DELETE",
                    success: function(response) {
                        if(response.success) {
                            Swal.fire('Terhapus!', response.message, 'success');
                            table.ajax.reload(null, false);
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'Terjadi kesalahan saat menghapus data.', 'error');
                    }
                });
            }
        });
    });
});
</script>
@endpush
