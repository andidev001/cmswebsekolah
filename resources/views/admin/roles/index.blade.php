@extends('layouts.admin')

@section('title', 'Peran / Role')
@section('page-title', 'Peran / Role')

@section('content')
<div class="card">
    <div class="card-header border-bottom py-3">
        <h5 class="m-0 fw-bold text-dark"><i class="fa-solid fa-shield-halved me-2 text-primary"></i> Daftar Peran</h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped w-100" id="roles-table">
                <thead>
                    <tr>
                        <th width="80">No</th>
                        <th>Nama Mesin</th>
                        <th>Nama Peran</th>
                        <th>Deskripsi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Initialize Datatable
    $('#roles-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.roles.data') }}",
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
            { data: 'display_name', name: 'display_name' },
            { data: 'description', name: 'description' }
        ],
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
        }
    });
});
</script>
@endpush
