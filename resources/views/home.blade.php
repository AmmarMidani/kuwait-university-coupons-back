@extends('layouts.app')

@section('pagename')
{{ trans('website.dashboard') }}
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">{{ trans('website.dashboard') }}</h4>
        <p class="mb-0">{{ trans('website.dashboard_title_details') }}</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-4">
        <!-- action buttons -->
    </div>
</div>

<div class="row mb-6">
    <div class="col-sm-6 col-lg-3">
        <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded-3 bg-label-primary">
                            <i class="ri-group-line ri-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $counts['merchants'] }}</h4>
                </div>
                <h6 class="mb-0 fw-normal">{{ __('website.merchants') }}</h6>
                <p class="mb-0">
                    <small class="text-muted">{{ __('website.total_in_system') }}</small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-border-shadow-warning h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded-3 bg-label-warning">
                            <i class="ri-graduation-cap-line ri-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $counts['students'] }}</h4>
                </div>
                <h6 class="mb-0 fw-normal">{{ __('website.students') }}</h6>
                <p class="mb-0">
                    <small class="text-muted">{{ __('website.total_in_system') }}</small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-border-shadow-danger h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded-3 bg-label-danger">
                            <i class="ri-restaurant-2-line ri-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $counts['meals'] }}</h4>
                    <div class="d-flex align-items-center">
                        @if ($counts['meal_change_status'])
                        <p class="mb-0 text-success me-0">{{ $counts['meals_change'] }}%</p>
                        <i class="ri-arrow-up-s-line text-success"></i>
                        @else
                        <p class="mb-0 text-danger me-0">{{ $counts['meals_change'] }}%</p>
                        <i class="ri-arrow-down-s-line text-danger"></i>
                        @endif
                    </div>

                </div>
                <h6 class="mb-0 fw-normal">{{ __('website.meals_provided') }}</h6>
                <p class="mb-0">
                    <span class="me-1 fw-medium">{{ $counts['meals_diff'] }}</span>
                    <small class="text-muted">{{ __('website.meal_than_last_week') }}</small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-border-shadow-info h-100">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-2 mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded-3 bg-label-info">
                            <i class="ri-survey-line ri-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $counts['surveys'] }}</h4>
                    <div class="d-flex align-items-center">
                        @if ($counts['survey_change_status'])
                        <p class="mb-0 text-success me-0">{{ $counts['survey_change'] }}%</p>
                        <i class="ri-arrow-up-s-line text-success"></i>
                        @else
                        <p class="mb-0 text-danger me-0">{{ $counts['survey_change'] }}%</p>
                        <i class="ri-arrow-down-s-line text-danger"></i>
                        @endif
                    </div>

                </div>
                <h6 class="mb-0 fw-normal">{{ __('website.completed_surveys') }}</h6>
                <p class="mb-0">
                    <span class="me-1 fw-medium">{{ $counts['survey_diff'] }}</span>
                    <small class="text-muted">{{ __('website.survey_than_last_week') }}</small>
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-6 mb-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-md-center align-items-start">
                <div>
                    <h5 class="card-title mb-0">{{ __('website.meals_provided') }}</h5>
                    <small class="text-muted">{{ __('website.daily_breakdown_of_meals_provided') }}</small>
                </div>
                <a href="#" class="btn btn-icon btn-outline-primary waves-effect">
                    <i class="ri-external-link-line"></i>
                </a>
            </div>
            <div class="card-body">
                <div id="barChart"></div>
            </div>
        </div>
    </div>

    <div class="col-6 mb-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h5 class="card-title mb-0">{{ __('website.student_satisfaction_index') }}</h5>
                    <small class="text-muted">{{ __('website.weekly_survey_results') }}</small>
                </div>
                <a href="#" class="btn btn-icon btn-outline-primary waves-effect">
                    <i class="ri-external-link-line"></i>
                </a>
            </div>
            <div class="card-body">
                <div id="lineChart"></div>
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
    const barChartEl = document.querySelector('#barChart'),
        barChartConfig = {
            series: @json($mealsChartData),
            chart: {
                type: 'bar',
                height: 350
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '75%',
                    borderRadius: 5,
                    borderRadiusApplication: 'end'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: @json($weekDays),
            },
        };
    if (typeof barChartEl !== undefined && barChartEl !== null) {
        const barChart = new ApexCharts(barChartEl, barChartConfig);
        barChart.render();
    }

    const lineChartEl = document.querySelector('#lineChart'),
        lineChartConfig = {
            series: @json($questionsChartData),
            chart: {
                height: 350,
                type: 'line',
                zoom: {
                    enabled: false
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2,
                curve: 'smooth'
            },
            grid: {
                row: {
                    colors: ['#f3f3f3', 'transparent'],
                    opacity: 0.5
                },
            },
            xaxis: {
                categories: @json($weekDays),
            }
        };
    if (typeof lineChartEl !== undefined && lineChartEl !== null) {
        const lineChart = new ApexCharts(lineChartEl, lineChartConfig);
        lineChart.render();
    }
})();
</script>
@endsection