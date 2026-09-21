@extends('layouts.admin')

@section('title', 'Database Alumni')
@section('page-title', 'Manajemen Database Alumni')

@section('content')
<div class="card">
    <div class="card-header border-bottom d-flex justify-content-between align-items-center py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-graduation-cap me-2 text-primary"></i> Daftar Database Alumni</h5>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.alumni.export') }}" class="btn btn-success btn-sm" id="export-excel-btn">
                <i class="fa-solid fa-file-excel me-1"></i> Export Excel
            </a>
            <button type="button" class="btn btn-primary btn-sm" id="create-btn">
                <i class="fa-solid fa-plus me-1"></i> Tambah Alumni
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="alumni-table">
                <thead>
                    <tr>
                        <th width="50">No</th>
                        <th>Nama Alumni</th>
                        <th>Tahun Lulus</th>
                        <th>Tahun Ajaran</th>
                        <th>Pekerjaan / Aktivitas</th>
                        <th>Melanjutkan Sekolah</th>
                        <th width="120">No. Telp</th>
                        <th>Email</th>
                        <th>Testimoni</th>
                        <th width="100">Status</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('modals')
<!-- Alumni Modal -->
<div class="modal fade" id="alumni-modal" tabindex="-1" aria-labelledby="alumniModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="alumniModalLabel">Form Alumni</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="alumni-form">
                <input type="hidden" id="alumni-id" name="alumni_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="alumni_name" class="form-label">Nama Alumni</label>
                        <input type="text" class="form-control" id="alumni_name" name="name" placeholder="Masukkan nama lengkap alumni" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="alumni_year" class="form-label">Tahun Lulus</label>
                            <input type="number" class="form-control" id="alumni_year" name="graduation_year" placeholder="Contoh: 2023" min="1970" max="{{ date('Y')+1 }}" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="alumni_tahun_ajaran" class="form-label">Tahun Ajaran</label>
                            <input type="text" class="form-control" id="alumni_tahun_ajaran" name="tahun_ajaran" placeholder="Contoh: 2022/2023">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="alumni_job" class="form-label">Pekerjaan / Kegiatan</label>
                            <input type="text" class="form-control" id="alumni_job" name="job" placeholder="Contoh: QC di PT. Gajah Tunggal">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alumni_melanjutkan_sekolah" class="form-label">Melanjutkan Sekolah</label>
                        <input type="text" class="form-control" id="alumni_melanjutkan_sekolah" name="melanjutkan_sekolah" placeholder="Contoh: Universitas Indonesia / SMP Negeri 1">
                        <small class="text-muted">Isi jika alumni melanjutkan pendidikan ke jenjang berikutnya.</small>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <label for="alumni_phone" class="form-label">No. Telepon</label>
                            <input type="text" class="form-control" id="alumni_phone" name="phone" placeholder="Masukkan no. handphone">
                        </div>
                        <div class="col-sm-6 mb-3">
                            <label for="alumni_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="alumni_email" name="email" placeholder="Masukkan email alumni">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="alumni_testimonial" class="form-label">Kesan / Testimoni terhadap Sekolah</label>
                        <textarea class="form-control" id="alumni_testimonial" name="testimonial" rows="3" placeholder="Tulis kesan/pesan singkat selama sekolah..."></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="alumni_is_approved" class="form-label">Status Testimoni</label>
                        <select class="form-select" id="alumni_is_approved" name="is_approved">
                            <option value="0">Menunggu Persetujuan</option>
                            <option value="1">Disetujui (Tampil di Publik)</option>
                        </select>
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
    let table = $('#alumni-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.alumni.data') }}",
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
            { data: 'graduation_year', name: 'graduation_year' },
            { data: 'tahun_ajaran', name: 'tahun_ajaran', defaultContent: '-' },
            { data: 'job', name: 'job', defaultContent: '-' },
            { data: 'melanjutkan_sekolah', name: 'melanjutkan_sekolah', defaultContent: '-' },
            { data: 'phone', name: 'phone', defaultContent: '-' },
            { data: 'email', name: 'email', defaultContent: '-' },
            { data: 'testimonial', name: 'testimonial', defaultContent: '-', render: function(data){ return data && data.length > 50 ? data.substr(0, 50) + '...' : data; } },
            { data: 'is_approved', name: 'is_approved', orderable: true, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });

    // Reset Form Modal
    function resetForm() {
        $('#alumni-form')[0].reset();
        $('#alumni-id').val('');
        $('#alumni_is_approved').val('1'); // Default to approved for admin additions
        $('#alumniModalLabel').text('Tambah Alumni');
        $('#save-btn').text('Simpan');
    }

    // Open Modal for Create
    $('#create-btn').on('click', function() {
        resetForm();
        $('#alumni-modal').modal('show');
    });

    // Handle Form Submit
    $('#alumni-form').on('submit', function(e) {
        e.preventDefault();

        let id = $('#alumni-id').val();
        let url = id ? "{{ url('admin/alumni/update') }}/" + id : "{{ route('admin.alumni.store') }}";
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
                    $('#alumni-modal').modal('hide');
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
            url: "{{ url('admin/alumni/show') }}/" + id,
            type: "GET",
            success: function(response) {
                $('#alumni-id').val(response.id);
                $('#alumni_name').val(response.name);
                $('#alumni_year').val(response.graduation_year);
                $('#alumni_tahun_ajaran').val(response.tahun_ajaran);
                $('#alumni_job').val(response.job);
                $('#alumni_melanjutkan_sekolah').val(response.melanjutkan_sekolah);
                $('#alumni_phone').val(response.phone);
                $('#alumni_email').val(response.email);
                $('#alumni_testimonial').val(response.testimonial);
                $('#alumni_is_approved').val(response.is_approved ? '1' : '0');

                $('#alumniModalLabel').text('Edit Alumni');
                $('#save-btn').text('Perbarui');
                $('#alumni-modal').modal('show');
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

    // Handle Toggle Approve Button
    $(document).on('click', '.toggle-approve-btn', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Mengubah status...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: "{{ url('admin/alumni/toggle-approve') }}/" + id,
            type: "POST",
            success: function(response) {
                Swal.close();
                if(response.success) {
                    table.ajax.reload(null, false); // reload table keeping pagination page
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: response.message,
                        timer: 1000,
                        showConfirmButton: false
                    });
                }
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: 'Gagal mengubah status persetujuan.'
                });
            }
        });
    });

    // Handle Delete Button
    $(document).on('click', '.delete-btn', function() {
        let id = $(this).data('id');

        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data alumni yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ea5455',
            cancelButtonColor: '#a8aaae',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/alumni/destroy') }}/" + id,
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
