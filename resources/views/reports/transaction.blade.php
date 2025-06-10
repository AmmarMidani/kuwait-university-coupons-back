@extends('layouts.app')

@section('pagename')
{{ __('website.transaction_report') }}
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">{{ __('website.transaction_report') }}</h4>
        <p class="mb-0">{{ __('website.view_and_search_student_meal_transactions') }}</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-4">
        <!-- action buttons -->
    </div>
</div>

<!-- DataTable with Buttons -->
<div class="card">
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-3 px-2">
                <div class="form-floating form-floating-outline">
                    <input type="text" id="bs-rangepicker-basic" class="form-control" />
                    <label for="bs-rangepicker-basic">{{ __('website.date_range') }}</label>
                </div>
            </div>
            <div class="col-3 px-2">
                <div class="form-floating form-floating-outline">
                    {{ html()
                    ->select('meal_id', $meals, null)
                    ->class('form-select select2')
                    }}
                    <label>{{ __('website.meals') }}</label>
                </div>
            </div>
            <div class="col-3 px-2">
                <div class="form-floating form-floating-outline">
                    {{ html()
                    ->select('student_id', $students, null)
                    ->class('form-select select2')
                    }}
                    <label>{{ __('website.students') }}</label>
                </div>
            </div>
            <div class="col-3 px-2">
                <div class="form-floating form-floating-outline">
                    {{ html()
                    ->select('user_id', $users, null)
                    ->class('form-select select2')
                    }}
                    <label>{{ __('website.users') }}</label>
                </div>
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

    $(".select2").select2();

    var bsRangePickerBasic = $('#bs-rangepicker-basic');

    if (bsRangePickerBasic.length) {
        bsRangePickerBasic.daterangepicker({
            opens: isRtl ? 'left' : 'right',
            startDate: '{{ $date_from }}',
            endDate: '{{ $date_to }}',
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    }

    var _datatable_js = $('#table_datatable').DataTable({
        dom: "<'row'<'col-sm-3'l><'col-sm-6 text-center'B><'col-sm-3'f>>rtip",
        buttons: [
            {
                extend: 'copy',
                className: 'btn btn-sm btn-outline-info mx-1',
            },
            {
                extend: 'excel',
                className: 'btn btn-sm btn-outline-success mx-1',
            },
            {
                extend: 'pdf',
                className: 'btn btn-sm btn-outline-danger mx-1',
            },
            {
                extend: 'print',
                className: 'btn btn-sm btn-outline-default mx-1',
            }
        ],
        lengthMenu: [
            [7, 10, 25, 50, 75, 100, -1],
            [7, 10, 25, 50, 75, 100, "All"]
        ],
        pageLength: 50,
        search: {
            return: true,
        },
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('report.transaction') }}",
            data: function (data) {
                let dateRange = $('#bs-rangepicker-basic').val();
                let [date_from, date_to] = dateRange.split(' - ');
                data.date_from = date_from;
                data.date_to = date_to;
                data.meal_id = $('#meal_id').val();
                data.student_id = $('#student_id').val();
                data.user_id = $('#user_id').val();
            },
        },
        columnDefs: [
            { name: "transaction_id", targets: 0 },
            { name: "student_id", targets: 1 },
            { name: "student_name", targets: 2 },
            { name: "meal_type", targets: 3 },
            { name: "staff_name", targets: 4 },
            { name: "is_answerd", targets: 5 },
            { name: "created_at", targets: 6 },
        ],
        columns: [
            {
                title: "{{ __('website.transaction_id') }}",
                render: function (data, type, row) {
                    return `#${row.transaction_id}`;
                },
            },
            {
                title: "{{ __('website.student_id') }}",
                render: function (data, type, row) {
                    return `#${row.student_number}
                        <a href="${row.student_show_url}" target="blank">
                            <i class="ri-attachment-2 cursor-pointer"></i>
                        </a>`;
                },
            },
            {
                title: "{{ __('website.student_name') }}",
                render: function (data, type, row) {
                    return `${row.student_name}`;
                },
            },
            {
                title: "{{ __('website.meal_type') }}",
                render: function (data, type, row) {
                    return `<span class="badge rounded-pill bg-label-primary">${row.meal_type}</span>`;
                },
            },
            {
                title: "{{ __('website.staff_name') }}",
                render: function (data, type, row) {
                    return `#${row.staff_name}
                        <a href="${row.user_show_url}" target="blank">
                            <i class="ri-attachment-2 cursor-pointer"></i>
                        </a>`;
                },
            },
            {
                title: "{{ __('website.do_the_survey') }}",
                render: function (data, type, row) {
                    if (row.is_answerd) {
                        return `<i class="ri-check-double-line text-success"></i>`;
                    } else {
                        return `<i class="ri-close-line text-danger"></i>`;
                    }
                },
            },
            {
                title: "{{ __('website.created_at') }}",
                render: function (data, type, row) {
                    return `${row.created_at}`;
                },
            },
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

    $('#bs-rangepicker-basic, #meal_id, #student_id, #user_id').change(function (e) {
        _datatable_js.ajax.reload();
    });
});

</script>
@endsection