@extends('layouts.admin')

@section('title', 'Daftar Artikel')
@section('page-title', 'Manajemen Artikel / Blog')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-newspaper me-2 text-primary"></i> Daftar Artikel</h5>
        <button type="button" class="btn btn-primary btn-sm" id="create-btn">
            <i class="fa-solid fa-plus me-1"></i> Tambah Artikel
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="posts-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Thumbnail</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Views</th>
                        <th>Status</th>
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
<!-- Post Modal (Larger size) -->
<div class="modal fade" id="post-modal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="postModalLabel">Form Artikel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="post-form" enctype="multipart/form-data">
                <input type="hidden" id="post-id" name="post_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="post_title" class="form-label">Judul Artikel</label>
                                <input type="text" class="form-control" id="post_title" name="title" placeholder="Masukkan judul artikel" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Kategori</label>
                                <select class="form-select" id="category_id" name="category_id" required>
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    @foreach($categories as $cat)
                                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="post_content" class="form-label">Konten / Isi Artikel</label>
                        <!-- CKEditor Textarea container -->
                        <textarea class="form-control" id="post_content" name="content" rows="10"></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="post_image" class="form-label">Gambar Thumbnail</label>
                                <input type="file" class="form-control" id="post_image" name="image" accept="image/*">
                                <small class="text-muted">Maksimal 2MB, format: JPG, JPEG, PNG</small>
                                <div class="mt-2" id="current-image-container" style="display: none;">
                                    <small class="text-muted d-block">Gambar Saat Ini:</small>
                                    <img src="" alt="Thumbnail" class="img-thumbnail" id="current-image-preview" style="max-height: 100px;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="post_status" class="form-label">Status</label>
                                <select class="form-select" id="post_status" name="status" required>
                                    <option value="published" selected>Published</option>
                                    <option value="draft">Draft</option>
                                </select>
                            </div>
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

@push('styles')
<style>
/* Adjust CKEditor height in modal */
.ck-editor__editable_inline {
    min-height: 250px;
}
</style>
@endpush

@push('scripts')
<!-- CKEditor 5 Classic CDN -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
<script>
$(document).ready(function() {
    let editorInstance;

    // Initialize CKEditor 5
    ClassicEditor
        .create(document.querySelector('#post_content'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', 'insertTable', 'undo', 'redo' ]
        })
        .then(editor => {
            editorInstance = editor;
        })
        .catch(error => {
            console.error(error);
        });

    // Initialize Datatable
    let table = $('#posts-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.posts.data') }}",
        columns: [
            {
                data: null,
                searchable: false,
                orderable: false,
                render: function (data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            { data: 'thumbnail', name: 'thumbnail', orderable: false, searchable: false },
            { data: 'title', name: 'title' },
            { data: 'category_name', name: 'category_name', orderable: false },
            { data: 'views', name: 'views' },
            { data: 'status', name: 'status' },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });

    // Reset Form Modal
    function resetForm() {
        $('#post-form')[0].reset();
        $('#post-id').val('');
        $('#current-image-container').hide();
        $('#current-image-preview').attr('src', '');
        $('#postModalLabel').text('Tambah Artikel');
        $('#save-btn').text('Simpan');
        if (editorInstance) {
            editorInstance.setData('');
        }
    }

    // Open Modal for Create
    $('#create-btn').on('click', function() {
        resetForm();
        $('#post-modal').modal('show');
    });

    // Handle Form Submit
    $('#post-form').on('submit', function(e) {
        e.preventDefault();

        // Copy content from CKEditor to textarea before serializing
        if (editorInstance) {
            $('#post_content').val(editorInstance.getData());
        }

        let id = $('#post-id').val();
        let url = id ? "{{ url('admin/posts/update') }}/" + id : "{{ route('admin.posts.store') }}";
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
                    $('#post-modal').modal('hide');
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
            url: "{{ url('admin/posts/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#post-id').val(response.id);
                $('#post_title').val(response.title);
                $('#category_id').val(response.category_id);
                $('#post_status').val(response.status);
                
                if (editorInstance) {
                    editorInstance.setData(response.content);
                }

                if (response.image_url) {
                    $('#current-image-preview').attr('src', response.image_url);
                    $('#current-image-container').show();
                }

                $('#postModalLabel').text('Edit Artikel');
                $('#save-btn').text('Perbarui');
                $('#post-modal').modal('show');
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
            text: "Artikel yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea5455',
            cancelButtonColor: '#a8aaae',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/posts/destroy') }}/" + id,
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
