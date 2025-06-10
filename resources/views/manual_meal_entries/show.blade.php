@extends('layouts.app')

@section('pagename')
Bulk Meals Manual Entry
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">Bulk Meals Manual Entry</h4>
        <p class="mb-0">Add a meal entry if the internet connection is down</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-4">
        <!-- action buttons -->
    </div>
</div>

<div class="row mb-4">
    <div class="col-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-tile mb-0">Add single row</h5>
                <p class="text-muted">Add entry for single student</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            {{ html()
                            ->select('user_id_single', $users, null)
                            ->class('form-select select2')
                            }}
                            <label>Merchant</label>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            {{ html()
                            ->select('meal_id_single', $meals, null)
                            ->class('form-select select2')
                            }}
                            <label>Meal</label>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input class="datepicker form-control" name="effective_date_single"
                                id="effective_date_single" />
                            <label for="effective_date_single">Date</label>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            {{ html()
                            ->select('student_id_single', $students, null)
                            ->class('form-select select2')
                            }}
                            <label>Student</label>
                        </div>
                    </div>
                    <div class="col-12">
                        <button id="add-single-entry-btn" type="button"
                            class="btn btn-sm btn-outline-info waves-effect">
                            Check and add to list
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-tile mb-0">Bulk add</h5>
                <p class="text-muted">Add entry for multiple students</p>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            {{ html()
                            ->select('user_id_bulk', $users, null)
                            ->class('form-select select2')
                            }}
                            <label>Merchant</label>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            {{ html()
                            ->select('meal_id_bulk', $meals, null)
                            ->class('form-select select2')
                            }}
                            <label>Meal</label>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <input class="datepicker form-control" name="effective_date_bulk"
                                id="effective_date_bulk" />
                            <label for="effective_date_bulk">Date</label>
                        </div>
                    </div>
                    <div class="col-12 mb-4">
                        <div class="form-floating form-floating-outline">
                            <textarea type="text" name="student_numbers" class="form-control h-px-100"
                                placeholder="Student Numbers" aria-describedby="student_numbers_help"></textarea>
                            <label for="student_numbers">Student Numbers</label>
                            <div id="student_numbers_help" class="form-text">
                                Student numbers (only single number for each row)
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button id="add-bulk-entry-btn" type="button" class="btn btn-sm btn-outline-info waves-effect">
                            Check and add to list
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div
                class="card-header d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-0">
                <div class="d-flex flex-column justify-content-center">
                    <h5 class="card-tile mb-0">Waiting list inputs</h5>
                    <p class="text-muted">Data will stored when you click on save</p>
                </div>
                <div class="d-flex align-content-center flex-wrap gap-4">
                    <button id="save-verified-btn" type="button" class="btn btn-sm btn-outline-success waves-effect">
                        Save
                    </button>
                </div>
            </div>
            <div class="table-responsive text-nowrap">
                <table class="table table-sm table-hover table-striped table-borderless" id="meal-entries-table">
                    <thead>
                        <tr>
                            <th>Student Number</th>
                            <th>Student Name</th>
                            <th>Meal</th>
                            <th>Merchant</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js_plugin')
@endsection

@section('js')
<script>
    'use strict';

(function () {
    const insertedHashes = new Set();

    function handle_error(xhr) {
        let message = 'Something went wrong. Please try again.';

        if (xhr.responseJSON?.message) {
            message = xhr.responseJSON.message;
        } else if (xhr.responseJSON?.errors) {
            const errors = xhr.responseJSON.errors;
            message = Object.values(errors).flat().join('<br>');
        }
        Swal.fire({
            title: 'Error!',
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

    function resetBulkForm() {
        $('#user_id_bulk').val(null).trigger('change');
        $('#meal_id_bulk').val(null).trigger('change');
        $('#effective_date_bulk').val('');
        $('textarea[name="student_numbers"]').val('');
    }

    $(".datepicker").flatpickr({});
    $(".select2").select2();

    $('#add-single-entry-btn').on('click', function () {
        $.ajax({
            url: '{{ route("manual-meal-entry.verify") }}',
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                student_ids: [$('#student_id_single').val()],
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

    $('#add-bulk-entry-btn').on('click', function () {
        // Get student numbers from textarea
        let studentNumbers = $('textarea[name="student_numbers"]')
            .val()
            .split('\n')
            .map(num => num.trim()) // Remove whitespace
            .filter(num => num !== '') // Remove empty lines
            .filter((value, index, self) => self.indexOf(value) === index); // Get unique values

        $.ajax({
            url: '{{ route("manual-meal-entry.verify") }}',
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                student_ids: studentNumbers,
                meal_id: $('#meal_id_bulk').val(),
                user_id: $('#user_id_bulk').val(),
                effective_date: $('#effective_date_bulk').val(),
            },
            beforeSend: function () {
                // $('#report-content').html('<div class="text-center p-4">{{ __("website.loading") }}</div>');
            },
            success: function (response) {
                if (response?.data) {
                    response.data.forEach(entry => addEntryRow(entry));
                    resetBulkForm();
                }
            },
            error: handle_error,
        });
    });

    $('#save-verified-btn').on('click', function () {
        const rows = $('#meal-entries-table tbody tr');
        if (rows.length === 0) {
            Swal.fire({
                title: 'No entries',
                text: 'Please add some verified entries before saving',
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
                    title: 'Saved!',
                    text: response.message || 'Data has been saved successfully.',
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

    $(document).on('click', '.cm-delete-row', function () {
        const row = $(this).closest('tr');
        const hash = row.data('hash');
        insertedHashes.delete(hash);
        row.remove();
    });
})();
</script>
@endsection
