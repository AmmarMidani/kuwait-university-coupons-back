<div class="row mb-6">
    <div class="col-sm-6 col-lg-3">
        <div class="card card-border-shadow-primary h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded-3 bg-label-primary">
                            <i class="ri-restaurant-line ri-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $counts['totalMealsServed'] }}</h4>
                </div>
                <h6 class="mb-0 fw-normal">Total Meals Served</h6>
                <p class="mb-0">
                    <small class="text-muted">
                        The total number of meals distributed during the selected period.
                    </small>
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
                            <i class="ri-line-chart-line ri-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $counts['averageDailyMeals'] }}</h4>
                </div>
                <h6 class="mb-0 fw-normal">Average Daily Meals</h6>
                <p class="mb-0">
                    <small class="text-muted">
                        The average number of meals served per day within the selected date range.
                    </small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-border-shadow-danger h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded-3 bg-label-danger">
                            <i class="ri-timer-flash-line ri-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $counts['studentsServed'] }}</h4>
                </div>
                <h6 class="mb-0 fw-normal">Students Served</h6>
                <p class="mb-0">
                    <small class="text-muted">
                        The number of unique students who received at least one meal.
                    </small>
                </p>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-lg-3">
        <div class="card card-border-shadow-info h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-2">
                    <div class="avatar me-4">
                        <span class="avatar-initial rounded-3 bg-label-info">
                            <i class="ri-graduation-cap-line ri-24px"></i>
                        </span>
                    </div>
                    <h4 class="mb-0">{{ $counts['averageMealTime'] }}</h4>
                </div>
                <h6 class="mb-0 fw-normal">Average Meal Time</h6>
                <p class="mb-0">
                    <small class="text-muted">
                        The typical hour when most meals are taken, based on recorded activity.
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
                    <h5 class="card-title mb-0">Monthly Meal Distribution</h5>
                    <small class="text-muted">
                        Shows the total number of meals served each month within the selected date range.
                    </small>
                </div>
            </div>
            <div class="card-body">
                <div id="monthlyMealDistributionChart"></div>
            </div>
        </div>
    </div>

    <div class="col-6 mb-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h5 class="card-title mb-0">Weekday Distribution</h5>
                    <small class="text-muted">
                        Displays how meal service is distributed across days of the week, helping identify peak service
                        days.
                    </small>
                </div>
            </div>
            <div class="card-body">
                <div id="weekdayDistributionChart"></div>
            </div>
        </div>
    </div>

    <div class="col-12 mb-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div>
                    <h5 class="card-title mb-0">Meal Type Distribution</h5>
                    <small class="text-muted">
                        Breaks down meals by type to highlight preferences or service trends.
                    </small>
                </div>
            </div>
            <div class="card-body">
                <div id="mealTypeDistributionChart"></div>
            </div>
        </div>
    </div>
</div>

<script>
    'use strict';

(function () {
    const barChart1El = document.querySelector('#monthlyMealDistributionChart'),
        barChart1Config = {
            series: @json($monthly_meal_distribution_series),
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
                categories: @json($monthly_meal_distribution_categories),
            },
        };
    if (typeof barChart1El !== undefined && barChart1El !== null) {
        const barChart1 = new ApexCharts(barChart1El, barChart1Config);
        barChart1.render();
    }

    const barChart2El = document.querySelector('#weekdayDistributionChart'),
        barChart2Config = {
            series: @json($weekday_distribution_series),
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
                categories: @json($weekday_distribution_categories),
            },
        };
    if (typeof barChart2El !== undefined && barChart2El !== null) {
        const barChart2 = new ApexCharts(barChart2El, barChart2Config);
        barChart2.render();
    }

    const barChart3El = document.querySelector('#mealTypeDistributionChart'),
        barChart3Config = {
            series: @json($meal_type_distribution_series),
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
                categories: @json($meal_type_distribution_categories),
            },
        };
    if (typeof barChart3El !== undefined && barChart3El !== null) {
        const barChart3 = new ApexCharts(barChart3El, barChart3Config);
        barChart3.render();
    }
})();
</script>
