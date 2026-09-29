@extends('layouts.admin')

@section('title', 'Manajemen Unduhan')

@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Manajemen Unduhan</h1>
        <button class="btn btn-primary shadow-sm" id="btn-add-new">
            <i class="fa-solid fa-plus fa-sm text-white-50"></i> Tambah Unduhan
        </button>
    </div>

    <div class="card shadow mb-4 border-0">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover" id="downloads-table" width="100%" cellspacing="0">
                    <thead class="bg-primary text-white">
                        <tr>
                            <th width="5%">No</th>
                            <th>Judul</th>
                            <th>Deskripsi</th>
                            <th>File PDF</th>
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
<div class="modal fade" id="download-modal" tabindex="-1" aria-labelledby="downloadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="download-form" enctype="multipart/form-data">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="downloadModalLabel">Tambah Unduhan</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="download-id" name="id">
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul File <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Singkat</label>
                        <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="file" class="form-label">Upload File PDF</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf">
                        <small class="text-muted" id="file-help">Maksimal ukuran file 10MB.</small>
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

    let table = $('#downloads-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.downloads.data') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            {data: 'title', name: 'title'},
            {data: 'description', name: 'description'},
            {data: 'file_link', name: 'file_link', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    function resetForm() {
        $('#download-form')[0].reset();
        $('#download-id').val('');
        $('#downloadModalLabel').text('Tambah Unduhan');
        $('#save-btn').text('Simpan');
        $('#file-help').text('Maksimal ukuran file 10MB.');
        $('#file').prop('required', true);
    }

    $('#btn-add-new').click(function() {
        resetForm();
        $('#download-modal').modal('show');
    });

    $('#download-form').submit(function(e) {
        e.preventDefault();
        
        let id = $('#download-id').val();
        let url = id ? "{{ url('admin/downloads/update') }}/" + id : "{{ route('admin.downloads.store') }}";
        
        let formData = new FormData(this);
        // Important for CSRF in FormData
        formData.append('_token', $('meta[name="csrf-token"]').attr('content'));

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
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                Swal.close();
                if(response.success) {
                    $('#download-modal').modal('hide');
                    Swal.fire('Berhasil!', response.message, 'success');
                    table.ajax.reload();
                }
            },
            error: function(xhr) {
                Swal.close();
                let errorMsg = 'Terjadi kesalahan sistem. (Code: ' + xhr.status + ')';
                
                if (xhr.responseJSON) {
                    if (xhr.responseJSON.errors) {
                        errorMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                    } else if (xhr.responseJSON.message) {
                        errorMsg = xhr.responseJSON.message;
                    }
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    html: errorMsg
                });
            }
        });
    });

    $(document).on('click', '.edit-btn', function() {
        let id = $(this).data('id');
        resetForm();
        
        $.ajax({
            url: "{{ url('admin/downloads/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#download-id').val(response.id);
                $('#title').val(response.title);
                $('#description').val(response.description);
                $('#file').prop('required', false);
                $('#file-help').text('Maksimal ukuran file 10MB. Kosongkan jika tidak ingin mengubah file PDF.');
                
                $('#downloadModalLabel').text('Edit Unduhan');
                $('#save-btn').text('Perbarui');
                $('#download-modal').modal('show');
            },
            error: function() {
                Swal.fire('Error', 'Data tidak ditemukan.', 'error');
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
                    url: "{{ url('admin/downloads/destroy') }}/" + id,
                    type: "DELETE",
                    success: function(response) {
                        if(response.success) {
                            Swal.fire('Terhapus!', response.message, 'success');
                            table.ajax.reload();
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
