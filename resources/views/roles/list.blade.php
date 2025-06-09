@extends('layouts.app')

@section('pagename')
Roles & Permissions
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">Roles & Permissions</h4>
        <p class="mb-0">View and manage roles & permissions</p>
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
                <a href="{{ route('role.create') }}" class="btn btn-inverse-primary btn-sm btn-icon-text">
                    <i class="btn-icon-prepend" data-feather="plus"></i>
                    Add New Item
                </a>
            </div>
        </div>

        <table id="table_datatable" class="table table-sm table-hover"></table>
    </div>
</div>
<!--/ DataTable with Buttons -->

<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="#" method="POST" id="frm_confirm_delete">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Delete Confirmation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js_plugin')
@endsection

@section('js')
<script>
    $(function () {
    'use strict';

    $("#table_datatable").on("click", ".cm-delete-row", function(){
        var row_id = $(this).data('id');
        var $route = "{{ route('role.destroy', 'xx') }}";
        $route = $route.replace('xx', row_id);
        $('#frm_confirm_delete').attr('action', $route)
        $('#deleteModal').modal('show');
    });

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
            url: "{{ route('role.index') }}",
            data: function (data) {
                // data.date_from = $('#fromDataAjax').val();
                // data.date_to = $('#toDataAjax').val();
                // data.author = $('#authors_list').val();
                // data.event = $('#events_list').val();
            },
        },
        columnDefs: [
            { name: "name", targets: 0 },
            { name: "created_at", targets: 1 },
            { name: "action", targets: 2 },
        ],
        columns: [
            {
                title: "name",
                render: function (data, type, row) {
                    return `${row.name}`;
                },
            },
            {
                title: "assigned to",
                render: function (data, type, row) {
                    return `${row.user_count}`;
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
                    if (row.editable) {
                        return `
                            <a href="${row.edit_url}" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit"><i class="ri-edit-box-line"></i></a>
                            <a href="${row.show_url}" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit"><i class="ri-eye-line"></i></a>
                            <button class="btn btn-sm btn-text-danger rounded-pill btn-icon item-edit cm-delete-row" data-id="${row.id}"><i class="ri-delete-bin-line"></i></button>
                        `;
                    } else {
                        return '';
                    }

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
