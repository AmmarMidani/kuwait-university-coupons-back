@extends('layouts.app')

@section('pagename')
{{ __('website.meal_prices') }}
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">{{ __('website.meal_prices') }}</h4>
        <p class="mb-0">{{ __('website.view_and_manage_meal_prices') }}</p>
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
                @can('meal_price_add')
                <a href="{{ route('meal-price.create') }}" class="btn btn-inverse-primary btn-sm btn-icon-text">
                    <i class="btn-icon-prepend" data-feather="plus"></i>
                    {{ __('website.add_new_item') }}
                </a>
                @endcan
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
            url: "{{ route('meal-price.index') }}",
            data: function (data) {
                // data.date_from = $('#fromDataAjax').val();
                // data.date_to = $('#toDataAjax').val();
                // data.author = $('#authors_list').val();
                // data.event = $('#events_list').val();
            },
        },
        columnDefs: [
            { name: "meal_name", targets: 0 },
            { name: "user_name", targets: 1 },
            { name: "price", targets: 2 },
            { name: "effective_date", targets: 3 },
            { name: "created_at", targets: 4 },
            { name: "action", targets: 5 },
        ],
        columns: [
            {
                title: "{{ __('website.meal') }}",
                render: function (data, type, row) {
                    return `${row.meal_name}
                        <a href="${row.meal_show_url}" target="blank">
                            <i class="ri-attachment-2 cursor-pointer"></i>
                        </a>`;
                },
            },
            {
                title: "{{ __('website.merchant') }}",
                render: function (data, type, row) {
                    return `${row.user_name}
                        <a href="${row.user_show_url}" target="blank">
                            <i class="ri-attachment-2 cursor-pointer"></i>
                        </a>`;
                },
            },
            {
                title: "{{ __('website.price') }}",
                render: function (data, type, row) {
                    return `${row.price}`;
                },
            },
            {
                title: "{{ __('website.effective_date') }}",
                render: function (data, type, row) {
                    return `${row.effective_date}`;
                },
            },
            {
                title: "{{ __('website.created_at') }}",
                render: function (data, type, row) {
                    return `${row.created_at}`;
                },
            },
            {
                // Actions
                targets: -1,
                orderable: false,
                searchable: false,
                title: "{{ __('website.actions') }}",
                class: "text-end",
                render: function (data, type, row) {
                    return `
                        @can('meal_price_edit')
                        <a href="${row.edit_url}" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit"><i class="ri-edit-box-line"></i></a>
                        @endcan
                        @can('meal_price_read')
                        <a href="${row.show_url}" class="btn btn-sm btn-text-secondary rounded-pill btn-icon item-edit"><i class="ri-eye-line"></i></a>
                        @endcan
                    `;
                }
            }
        ]
    });
    $('#table_datatable').each(function () {
        var datatable = $(this);
        // SEARCH - Add the placeholder for Search and Turn this into in-line form control
        var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
        search_input.attr('placeholder', '{{ __("website.search") }}');
        // LENGTH - Inline-Form control
        var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
        length_sel.removeClass('form-control-sm');
    });
});

</script>
@endsection
