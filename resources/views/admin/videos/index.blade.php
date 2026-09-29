@extends('layouts.admin')

@section('title', 'Kanal Video')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Kanal Video</h1>
        <button class="btn btn-primary shadow-sm" id="btn-add-new">
            <i class="fa-solid fa-plus fa-sm text-white-50"></i> Tambah Video
        </button>
    </div>

    <div class="card shadow mb-4 border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="videos-table" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="5%">No</th>
                            <th width="20%">Thumbnail</th>
                            <th width="40%">Judul Video</th>
                            <th width="10%">Status</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form -->
<div class="modal fade" id="video-modal" tabindex="-1" aria-labelledby="videoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="video-form">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="videoModalLabel">Tambah Video</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="video-id" name="id">
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Video <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="youtube_url" class="form-label">Link YouTube <span class="text-danger">*</span></label>
                        <input type="url" class="form-control" id="youtube_url" name="youtube_url" placeholder="Contoh: https://www.youtube.com/watch?v=..." required>
                        <small class="text-muted">Salin dan tempel link dari YouTube. URL akan otomatis dikonversi.</small>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Aktifkan Video (Tampil di Homepage)</label>
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
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let table = $('#videos-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.videos.data') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false},
            {data: 'title', name: 'title'},
            {data: 'status', name: 'is_active', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    function resetForm() {
        $('#video-form')[0].reset();
        $('#video-id').val('');
        $('#videoModalLabel').text('Tambah Video');
        $('#save-btn').text('Simpan');
        $('#is_active').prop('checked', true);
    }

    $('#btn-add-new').click(function() {
        resetForm();
        $('#video-modal').modal('show');
    });

    $('#video-form').submit(function(e) {
        e.preventDefault();
        
        let id = $('#video-id').val();
        let url = id ? "{{ url('admin/videos/update') }}/" + id : "{{ route('admin.videos.store') }}";

        Swal.fire({
            title: 'Menyimpan...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: url,
            type: "POST",
            data: $(this).serialize(),
            success: function(response) {
                Swal.close();
                if(response.success) {
                    $('#video-modal').modal('hide');
                    Swal.fire('Berhasil!', response.message, 'success');
                    table.ajax.reload(null, false);
                }
            },
            error: function(xhr) {
                Swal.close();
                let errorMsg = 'Terjadi kesalahan sistem.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMsg = xhr.responseJSON.message;
                }
                Swal.fire('Error', errorMsg, 'error');
            }
        });
    });

    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        resetForm();
        
        $.ajax({
            url: "{{ url('admin/videos/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#video-id').val(response.id);
                $('#title').val(response.title);
                $('#youtube_url').val(response.youtube_url);
                $('#is_active').prop('checked', response.is_active == 1);
                
                $('#videoModalLabel').text('Edit Video');
                $('#save-btn').text('Perbarui');
                $('#video-modal').modal('show');
            },
            error: function() {
                Swal.fire('Error', 'Data tidak ditemukan.', 'error');
            }
        });
    });

    $(document).on('click', '.toggle-status', function() {
        let id = $(this).data('id');
        $.ajax({
            url: "{{ url('admin/videos/toggle-status') }}/" + id,
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
                Swal.fire('Error', 'Terjadi kesalahan.', 'error');
            }
        });
    });

    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');
        
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data ini akan dihapus permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/videos/destroy') }}/" + id,
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
