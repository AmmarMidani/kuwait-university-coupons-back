@extends('layouts.app')

@section('pagename')
Meal Prices
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">Meal Prices</h4>
        <p class="mb-0">View and manage meal prices</p>
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
                    <span class="h6 me-1">ID:</span>
                    <span>#{{ $meal_price->id }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">Meal:</span>
                    <span>{{ $meal_price->meal->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">Merchant:</span>
                    <span>{{ $meal_price->user->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">Price:</span>
                    <span>{{ $meal_price->price }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">Effective Date:</span>
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
