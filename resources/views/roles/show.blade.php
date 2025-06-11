@extends('layouts.app')

@section('pagename')
{{ __('website.roles_permissions') }}
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">{{ __('website.roles_permissions') }}</h4>
        <p class="mb-0">{{ __('website.view_and_manage_roles_permissions') }}</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-4">
        <!-- action buttons -->
    </div>
</div>

<div class="card mb-4">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <div class="col-lg-6">
                <h5 class="card-title">{{ $role->name }}</h5>
            </div>
            <div class="col-lg-6 text-end">
                <a class="me-3 text-muted" type="button" data-bs-toggle="tooltip"
                    data-bs-title="Created at: {{ $role->created_at }}">
                    <i class="ri-timer-2-line"></i> {{ $role->created_at->diffForHumans() }}
                </a>
                <a class="text-muted" type="button" data-bs-toggle="tooltip"
                    data-bs-title="Updated at: {{ $role->updated_at }}">
                    <i class="ri-progress-5-line"></i> {{ $role->updated_at->diffForHumans() }}
                </a>
            </div>
        </div>
        <div class="info-container">
            <ul class="list-unstyled mb-0">
                <li class="mb-2">
                    <span class="h6 me-1">{{ __('website.name') }}:</span>
                    <span>{{ $role->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">{{ __('website.description') }}:</span>
                    <span>{{ $role->description }}</span>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="row">
    @foreach ($permissions as $group => $items)
    <div class="col-md-4 mb-4">
        <div class="card h-100">
            <div class="card-body">
                <h6 class="text-primary fw-bold mb-3">
                    {{ ucwords(str_replace('_', ' ', $group)) }}
                </h6>
                @foreach ($items as $permission)
                <div class="form-check mb-2">
                    <input type="checkbox" {{ $selected_roles->contains($permission->name) ? 'checked' : '' }}
                    class="form-check-input" disabled >
                    <label class="form-check-label">{{ $permission->description }}</label>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

@section('js_plugin')
@endsection

@section('js')
@endsection
