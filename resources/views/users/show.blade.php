@extends('layouts.app')

@section('pagename')
{{ __('website.users') }}
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">{{ __('website.users') }}</h4>
        <p class="mb-0">{{ __('website.view_and_manage_users') }}</p>
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
                <h5 class="card-title">{{ $user->name }}</h5>
            </div>
            <div class="col-lg-6 text-end">
                <a class="me-3 text-muted" type="button" data-bs-toggle="tooltip"
                    data-bs-title="Created at: {{ $user->created_at }}">
                    <i class="ri-timer-2-line"></i> {{ $user->created_at->diffForHumans() }}
                </a>
                <a class="text-muted" type="button" data-bs-toggle="tooltip"
                    data-bs-title="Updated at: {{ $user->updated_at }}">
                    <i class="ri-progress-5-line"></i> {{ $user->updated_at->diffForHumans() }}
                </a>
            </div>
        </div>
        <div class="info-container">
            <ul class="list-unstyled mb-6">
                <li class="mb-2">
                    <span class="h6 me-1">{{ __('website.id') }}:</span>
                    <span>#{{ $user->id }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">{{ __('website.name') }}:</span>
                    <span>{{ $user->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">{{ __('website.email') }}:</span>
                    <span>{{ $user->email }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">{{ __('website.status') }}:</span>
                    @if ($user->is_active)
                    <span class="badge bg-label-success rounded-pill">{{ __('website.active') }}</span>
                    @else
                    <span class="badge bg-label-danger rounded-pill">{{ __('website.inactive') }}</span>
                    @endif
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">{{ __('website.roles') }}:</span>
                    <span>
                        @foreach ($user->roles as $item)
                        <span class="badge rounded-pill bg-label-primary text-capitalize me-2">
                            {{ $item->name }}
                        </span>
                        @endforeach
                    </span>
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