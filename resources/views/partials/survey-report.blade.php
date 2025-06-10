<div class="row mb-6">
    <div class="col-sm-4 col-lg-4">
        <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded-3 bg-label-primary">
                            <i class="ri-restaurant-line ri-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $counts['overallSatisfaction'] }}</h4>
                </div>
                <h6 class="mb-0 fw-normal">{{ __('website.overall_satisfaction') }}</h6>
                <p class="mb-0">
                    <small class="text-muted">
                        {{ __('website.overall_satisfaction_desc') }}
                    </small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-lg-4">
        <div class="card card-border-shadow-warning h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded-3 bg-label-warning">
                            <i class="ri-line-chart-line ri-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $counts['totalResponses'] }}</h4>
                </div>
                <h6 class="mb-0 fw-normal">{{ __('website.total_responses') }}</h6>
                <p class="mb-0">
                    <small class="text-muted">
                        {{ __('website.total_responses_desc') }}
                    </small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-4 col-lg-4">
        <div class="card card-border-shadow-danger h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded-3 bg-label-danger">
                            <i class="ri-timer-flash-line ri-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $counts['completionRate'] }}</h4>
                </div>
                <h6 class="mb-0 fw-normal">{{ __('website.completion_rate') }}</h6>
                <p class="mb-0">
                    <small class="text-muted">
                        {{ __('website.completion_rate_desc') }}
                    </small>
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
                    <h5 class="card-title mb-0">{{ __('website.survey_participation_overview') }}</h5>
                    <small class="text-muted">{{ __('website.survey_participation_overview_desc') }}</small>
                </div>
            </div>
            <div class="card-body">
                <div id="surveyParticipationOverviewChart"></div>
            </div>
        </div>
    </div>

    <div class="col-6 mb-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-md-center align-items-start">
                <div>
                    <h5 class="card-title mb-0">{{ __('website.student_satisfaction_by_question_over_time') }}</h5>
                    <small class="text-muted">
                        {{ __('website.student_satisfaction_by_question_over_time_desc') }}
                    </small>
                </div>
            </div>
            <div class="card-body">
                <div id="studentSatisfactionByQuestionChart"></div>
            </div>
        </div>
    </div>
</div>

<script>
    'use strict';

(function () {
    const barChart1El = document.querySelector('#surveyParticipationOverviewChart'),
        barChart1Config = {
            series: @json($survey_participation_overview_chart['series']),
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
                categories: @json($survey_participation_overview_chart['categories']),
            },
        };
    if (typeof barChart1El !== undefined && barChart1El !== null) {
        const barChart1 = new ApexCharts(barChart1El, barChart1Config);
        barChart1.render();
    }

    const lineChartEl = document.querySelector('#studentSatisfactionByQuestionChart'),
        lineChartConfig = {
            series: @json($student_satisfaction_by_question_series),
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
                categories: @json($student_satisfaction_by_question_categories),
            }
        };
    if (typeof lineChartEl !== undefined && lineChartEl !== null) {
        const lineChart = new ApexCharts(lineChartEl, lineChartConfig);
        lineChart.render();
    }
})();
</script>