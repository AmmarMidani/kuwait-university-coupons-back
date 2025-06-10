@extends('layouts.app')

@section('pagename')
{{ __('website.survey_report') }}
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">{{ __('website.survey_report') }}</h4>
        <p class="mb-0">{{ __('website.analyze_feedback_from_students_about_food_service') }}</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-4">
        <!-- action buttons -->
    </div>
</div>

<div class="col-12 mb-6">
    <div class="card">
        <h5 class="card-header">
            <div class="row">
                <div class="col-md-6 col-12">
                    {{ __('website.report_filters') }}
                </div>
                <div class="col-md-6 col-12 d-flex align-items-end justify-content-end">
                    <button id="apply-filter-btn" type="button"
                        class="btn btn-sm btn-outline-secondary waves-effect">{{ __('website.apply_filter') }}</button>
                </div>
            </div>
        </h5>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 col-12">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="bs-rangepicker-basic" class="form-control" />
                        <label for="bs-rangepicker-basic">{{ __('website.date_range') }}</label>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-floating form-floating-outline">
                        {{ html()
                        ->select('question_id', $questions, $question_id)
                        ->class('form-select select2')
                        }}
                        <label>{{ __('website.questions') }}</label>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="form-floating form-floating-outline">
                        {{ html()
                        ->select('meal_id', $meals, $meal_id)
                        ->class('form-select select2')
                        }}
                        <label>{{ __('website.meals') }}</label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="report-content"></div>

@endsection

@section('js_plugin')
@endsection

@section('js')
<script>
    'use strict';

(function () {
    $('#apply-filter-btn').on('click', function () {
        let dateRange = $('#bs-rangepicker-basic').val();
        let [date_from, date_to] = dateRange.split(' - ');

        $.ajax({
            url: '{{ route("report.survey") }}',
            method: 'GET',
            data: {
                date_from: date_from,
                date_to: date_to,
                question_id: $('#question_id').val(),
                meal_id: $('#meal_id').val(),
            },
            beforeSend: function () {
                $('#report-content').html('<div class="text-center p-4">{{ __("website.loading") }}</div>');
            },
            success: function (response) {
                $('#report-content').html(response.view);
            },
            error: function () {
                $('#report-content').html('<div class="text-danger p-4">{{ __("website.failed_to_load_data") }}</div>');
            }
        });
    });

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
    $('#apply-filter-btn').trigger('click');
})();
</script>
@endsection