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
                <h5 class="card-title">{{ $meal_price->name }}</h5>
            </div>
            <div class="col-lg-6 text-end">
                <a class="me-3 text-muted" type="button" data-bs-toggle="tooltip"
                    data-bs-title="Created at: {{ $meal_price->created_at }}">
                    <i class="ri-timer-2-line"></i> {{ $meal_price->created_at->diffForHumans() }}
                </a>
                <a class="text-muted" type="button" data-bs-toggle="tooltip"
                    data-bs-title="Updated at: {{ $meal_price->updated_at }}">
                    <i class="ri-progress-5-line"></i> {{ $meal_price->updated_at->diffForHumans() }}
                </a>
            </div>
        </div>
        <div class="info-container">
            <ul class="list-unstyled mb-6">
                <li class="mb-2">
                    <span class="h6 me-1">{{ __('website.id') }}:</span>
                    <span>#{{ $meal_price->id }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">{{ __('website.meal') }}:</span>
                    <span>{{ $meal_price->meal->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">{{ __('website.merchant') }}:</span>
                    <span>{{ $meal_price->user->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">{{ __('website.price') }}:</span>
                    <span>{{ $meal_price->price }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">{{ __('website.effective_date') }}:</span>
                    <span>{{ $meal_price->effective_date }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>
@endsection

@section('js_plugin')
@endsection

@section('js')
@endsection