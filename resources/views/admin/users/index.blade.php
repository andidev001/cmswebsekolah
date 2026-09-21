@extends('layouts.admin')

@section('title', 'Data Pengguna')
@section('page-title', 'Data Pengguna')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-users me-2 text-primary"></i> Daftar Pengguna</h5>
        <button type="button" class="btn btn-primary btn-sm" id="create-btn">
            <i class="fa-solid fa-plus me-1"></i> Tambah Pengguna
        </button>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="users-table">
                <thead>
                    <tr>
                        <th width="80">No</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Peran / Role</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('modals')
<!-- User Modal -->
<div class="modal fade" id="user-modal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Form Pengguna</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="user-form">
                <input type="hidden" id="user-id" name="user_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" id="user_name" name="name" placeholder="Masukkan nama lengkap" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_email" class="form-label">Alamat Email</label>
                        <input type="email" class="form-control" id="user_email" name="email" placeholder="Masukkan alamat email" required>
                    </div>
                    <div class="mb-3">
                        <label for="user_role" class="form-label">Peran / Role</label>
                        <select class="form-select" id="user_role" name="role_id">
                            <option value="">Pilih Peran...</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->display_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="user_password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="user_password" name="password" placeholder="Masukkan password (min. 6 karakter)">
                        <small class="text-muted" id="password-help">Wajib diisi untuk pengguna baru.</small>
                    </div>
                    <div class="mb-3">
                        <label for="user_password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" class="form-control" id="user_password_confirmation" name="password_confirmation" placeholder="Ulangi password">
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
    let table = $('#users-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.users.data') }}",
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
            { data: 'role_name', name: 'role_name' },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });

    // Reset Form Modal
    function resetForm() {
        $('#user-form')[0].reset();
        $('#user-id').val('');
        $('#user_password').prop('required', true);
        $('#password-help').text('Wajib diisi untuk pengguna baru.');
        $('#userModalLabel').text('Tambah Pengguna');
        $('#save-btn').text('Simpan');
    }

    // Open Modal for Create
    $('#create-btn').on('click', function() {
        resetForm();
        $('#user-modal').modal('show');
    });

    // Handle Form Submit
    $('#user-form').on('submit', function(e) {
        e.preventDefault();
        
        let id = $('#user-id').val();
        let url = id ? "{{ url('admin/users/update') }}/" + id : "{{ route('admin.users.store') }}";
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
                    $('#user-modal').modal('hide');
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
            url: "{{ url('admin/users/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#user-id').val(response.id);
                $('#user_name').val(response.name);
                $('#user_email').val(response.email);
                $('#user_role').val(response.role_id);
                $('#user_password').prop('required', false);
                $('#password-help').text('Biarkan kosong jika tidak ingin mengubah password.');
                $('#userModalLabel').text('Edit Pengguna');
                $('#save-btn').text('Perbarui');
                $('#user-modal').modal('show');
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
            text: "Pengguna yang dihapus tidak dapat dipulihkan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea5455',
            cancelButtonColor: '#a8aaae',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/users/destroy') }}/" + id,
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
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal!',
                                text: response.message
                            });
                        }
                    },
                    error: function(xhr) {
                        let errorMsg = 'Gagal menghapus data.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMsg = xhr.responseJSON.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMsg
                        });
                    }
                });
            }
        });
    });
});
</script>
@endpush
