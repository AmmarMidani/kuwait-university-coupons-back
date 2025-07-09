@extends('layouts.app')

@section('pagename')
{{ __('website.bulk_meals_manual_entry') }}
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">{{ __('website.bulk_meals_manual_entry') }}</h4>
        <p class="mb-0">{{ __('website.add_a_meal_entry_if_the_internet_connection_is_down') }}</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-4">
        <!-- action buttons -->
    </div>
</div>

<div class="row mb-4">
    <div class="col-12">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-tile mb-0">{{ __('website.bulk_add') }}</h5>
                <p class="text-muted">{{ __('website.add_entry_for_multiple_students') }}</p>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            {{ html()
                            ->select('user_id_single', $users, null)
                            ->class('form-select select2')
                            }}
                            <label>{{ __('website.merchant') }}</label>
                        </div>
                    </div>
                    <div class="col-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            {{ html()
                            ->select('meal_id_single', $meals, null)
                            ->class('form-select select2')
                            }}
                            <label>{{ __('website.meal') }}</label>
                        </div>
                    </div>
                    <div class="col-4 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input class="datepicker form-control" name="effective_date_single"
                                id="effective_date_single" />
                            <label for="effective_date_single">{{ __('website.date') }}</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button id="add-single-entry-btn" type="button"
                            class="btn btn-sm btn-outline-info waves-effect">
                            {{ __('website.check_and_add_to_list') }}
                        </button>
                    </div>
                </div>
                <div class="row" id="checkboxes-div">
                    <div class="col-6">
                        <small class="fw-medium">{{ __('website.students') }}</small>
                    </div>
                    <div class="col-6 text-end">
                        <div class="col-sm-12 mb-3">
                            <a href="javascript:void(0);" class="fw-medium" id="btn_select_all">
                                {{ __('website.select_all') }}
                            </a> /
                            <a href="javascript:void(0);" class="fw-medium" id="btn_select_none">
                                {{ __('website.select_none') }}
                            </a>
                        </div>
                    </div>
                    {{-- @foreach ($students as $std_number => $std)
                    <div class="col-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="{{ $std_number }}"
                                id="chk_std_{{ $std_number }}" checked />
                            <label class="form-check-label" for="chk_std_{{ $std_number }}">
                                {{ $std }}
                            </label>
                        </div>
                    </div>
                    @endforeach --}}
                </div>
            </div>
        </div>
    </div>
</div>

@can('manual_meal_entry_add')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div
                class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-0">
                <div class="d-flex flex-column justify-content-center">
                    <h5 class="card-tile mb-0">{{ __('website.waiting_list_inputs') }}</h5>
                    <p class="text-muted">{{ __('website.data_will_stored_when_you_click_on_save') }}</p>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <button id="save-verified-btn" type="button" class="btn btn-sm btn-outline-success waves-effect">
                        {{ __('website.save') }}
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-sm table-hover table-striped table-borderless" id="meal-entries-table">
                    <thead>
                        <tr>
                            <th>{{ __('website.student_number') }}</th>
                            <th>{{ __('website.student_name') }}</th>
                            <th>{{ __('website.meal') }}</th>
                            <th>{{ __('website.merchant') }}</th>
                            <th>{{ __('website.date') }}</th>
                            <th>{{ __('website.action') }}</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@else
<div class="text-danger text-center">
    {{ __('website.need_permission') }}
</div>
@endcan

@endsection

@section('js_plugin')
@endsection

@section('js')
<script>
    'use strict';

(function () {
    $('#btn_select_all').click(function (e) {
        $("#checkboxes-div input:checkbox").prop('checked', true);
    });

    $('#btn_select_none').click(function (e) {
        $("#checkboxes-div input:checkbox").prop('checked', false);
    });

    const insertedHashes = new Set();

    function handle_error(xhr) {
        let message = '{{ __("website.something_went_wrong_please_try_again") }}';

        if (xhr.responseJSON?.message) {
            message = xhr.responseJSON.message;
        } else if (xhr.responseJSON?.errors) {
            const errors = xhr.responseJSON.errors;
            message = Object.values(errors).flat().join('<br>');
        }
        Swal.fire({
            title: '{{ __("website.error") }}!',
            text: message,
            icon: 'error',
            customClass: {
                confirmButton: 'btn btn-primary waves-effect waves-light'
            },
            buttonsStyling: false
        });
    }

    function addEntryRow(entry) {
        if (insertedHashes.has(entry.hash)) return;
        insertedHashes.add(entry.hash);
        const row = `
            <tr
                data-hash="${entry.hash}"
                data-meal-id="${entry.meal_id}"
                data-student-id="${entry.student_id}"
                data-user-id="${entry.user_id}"
                data-date="${entry.effective_date}"
            >
                <td>${entry.student_number}</td>
                <td>${entry.student_name}</td>
                <td>${entry.meal_name}</td>
                <td>${entry.merchant_name}</td>
                <td>${entry.effective_date}</td>
                <td>
                    <button class="btn btn-sm btn-text-danger rounded-pill btn-icon item-edit cm-delete-row">
                        <i class="ri-delete-bin-line"></i>
                    </button>
                </td>
            </tr>
        `;
        $('#meal-entries-table tbody').append(row);
    }

    function resetSingleForm() {
        $('#user_id_single').val(null).trigger('change');
        $('#meal_id_single').val(null).trigger('change');
        $('#student_id_single').val(null).trigger('change');
        $('#effective_date_single').val('');
    }

    $(".datepicker").flatpickr({});
    $(".select2").select2();

    $('#add-single-entry-btn').on('click', function () {
        $.ajax({
            url: '{{ route("manual-meal-entry.verify") }}',
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                student_ids: $("#checkboxes-div input:checkbox:checked").map(function () {
                    return this.value;
                }).get(),
                meal_id: $('#meal_id_single').val(),
                user_id: $('#user_id_single').val(),
                effective_date: $('#effective_date_single').val(),
            },
            beforeSend: function () {
                // $('#report-content').html('<div class="text-center p-4">{{ __("website.loading") }}</div>');
            },
            success: function (response) {
                if (response?.data) {
                    response.data.forEach(entry => addEntryRow(entry));
                    resetSingleForm();
                }
            },
            error: handle_error,
        });
    });

    $('#save-verified-btn').on('click', function () {
        const rows = $('#meal-entries-table tbody tr');
        if (rows.length === 0) {
            Swal.fire({
                title: '{{ __("website.no_entries") }}',
                text: '{{ __("website.please_add_some_verified_entries_before_saving") }}',
                icon: 'warning',
                customClass: {
                    confirmButton: 'btn btn-primary waves-effect waves-light'
                },
                buttonsStyling: false
            });
            return;
        }

        const payload = [];
        rows.each(function () {
            const $row = $(this);
            payload.push({
                meal_id: $row.data('meal-id'),
                student_id: $row.data('student-id'),
                user_id: $row.data('user-id'),
                effective_date: $row.data('date')
            });
        });

        $.ajax({
            url: '{{ route("manual-meal-entry.store") }}',
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                entries: payload
            },
            success: function (response) {
                Swal.fire({
                    title: '{{ __("website.saved") }}',
                    text: response.message || '{{ __("website.data_has_been_saved_successfully") }}',
                    icon: 'success',
                    customClass: {
                        confirmButton: 'btn btn-primary waves-effect waves-light'
                    },
                    buttonsStyling: false
                });

                $('#meal-entries-table tbody').empty();
                insertedHashes.clear();
            },
            error: handle_error
        });
    });

    $('#user_id_single').on('change', function () {
        const userId = $(this).val();

        $.ajax({
            url: '{{ route("manual-meal-entry.users") }}',
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                user_id: $('#user_id_single').val(),
            },
            success: function (response) {
                const students = response.data || {};

                // Clear current students list
                const $container = $('#checkboxes-div');
                $container.empty();

                // Header
                $container.append(`
                    <div class="col-6">
                        <small class="fw-medium">{{ __('website.students') }}</small>
                    </div>
                    <div class="col-6 text-end">
                        <div class="col-sm-12 mb-3">
                            <a href="javascript:void(0);" class="fw-medium" id="btn_select_all">
                                {{ __('website.select_all') }}
                            </a> /
                            <a href="javascript:void(0);" class="fw-medium" id="btn_select_none">
                                {{ __('website.select_none') }}
                            </a>
                        </div>
                    </div>
                `);

                // Student checkboxes
                Object.entries(students).forEach(([std_number, std_name]) => {
                    $container.append(`
                        <div class="col-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="${std_number}"
                                    id="chk_std_${std_number}" checked />
                                <label class="form-check-label" for="chk_std_${std_number}">
                                    ${std_name}
                                </label>
                            </div>
                        </div>
                    `);
                });

                // Re-bind select all/none
                $('#btn_select_all').click(function () {
                    $("#checkboxes-div input:checkbox").prop('checked', true);
                });

                $('#btn_select_none').click(function () {
                    $("#checkboxes-div input:checkbox").prop('checked', false);
                });
            },
            error: function (xhr) {
                handle_error(xhr);
            }
        });
    });

    $(document).on('click', '.cm-delete-row', function () {
        const row = $(this).closest('tr');
        const hash = row.data('hash');
        insertedHashes.delete(hash);
        row.remove();
    });
})();
</script>
@endsection
