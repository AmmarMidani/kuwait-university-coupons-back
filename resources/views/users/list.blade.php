@extends('layouts.app')

@section('pagename')
Users
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">Users</h4>
        <p class="mb-0">View and manage users</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-4">
        <!-- action buttons -->
    </div>
</div>

<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="col-lg-6">
                <h6 class="card-title"></h6>
            </div>
            <div class="col-lg-6 text-end">
                <a href="{{ route('user.create') }}" class="btn btn-inverse-primary btn-sm btn-icon-text">
                    <i class="btn-icon-prepend" data-feather="plus"></i>
                    Add New Item
                </a>
            </div>
        </div>

        <table id="table_datatable" class="table table-sm table-hover"></table>
    </div>
</div>
<!--/ DataTable with Buttons -->
@endsection

@section('js_plugin')
@endsection

@section('js')
<script>
    $(function () {
    'use strict';
    var _datatable_js = $('#table_datatable').DataTable({
        lengthMenu: [
            [7, 10, 25, 50, 75, 100, -1],
            [7, 10, 25, 50, 75, 100, "All"]
        ],
        pageLength: 10,
        search: {
            return: true,
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('user.index') }}",
            data: function (data) {
                // data.date_from = $('#fromDataAjax').val();
                // data.date_to = $('#toDataAjax').val();
                // data.author = $('#authors_list').val();
                // data.event = $('#events_list').val();
            },
        },
        columnDefs: [
            { name: "name", targets: 0 },
            { name: "email", targets: 1 },
            { name: "roles", targets: 2 },
            { name: "status", targets: 3 },
            { name: "created_at", targets: 4 },
            { name: "action", targets: 5 },
        ],
        columns: [
            {
                title: "name",
                render: function (data, type, row) {
                    return `${row.name}`;
                },
            },
            {
                title: "email",
                render: function (data, type, row) {
                    return `${row.email}`;
                },
            },
            {
                title: "roles",
                render: function (data, type, row) {
                    return row.roles.map(role => `<span class="badge rounded-pill bg-label-primary">${role}</span>`).join(' ');
                },
            },
            {
                title: "status",
                render: function (data, type, row) {
                    if (row.status) {
                        return `<span class="badge rounded-pill bg-label-success">${row.status_text}</span>`;
                    } else {
                        return `<span class="badge rounded-pill bg-label-danger">${row.status_text}</span>`;
                    }
                },
            },
            {
                title: "created at",
                render: function (data, type, row) {
                    return `${row.created_at}`;
                },
            },
            {
                // Actions
                targets: -1,
                orderable: false,
                searchable: false,
                title: "Actions",
                class: "text-end",
                render: function (data, type, row) {
                    return `
                        <a href="${row.edit_url}" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit"><i class="ri-edit-box-line"></i></a>
                        <a href="${row.show_url}" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit"><i class="ri-eye-line"></i></a>
                    `;
                }
            }
        ]
    });
    $('#table_datatable').each(function () {
        var datatable = $(this);
        // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', 'Search');
        // LENGTH - Inline-Form control
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
    });
});

</script>
@endsection
