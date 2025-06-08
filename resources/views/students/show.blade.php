@extends('layouts.app')

@section('pagename')
Students
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">Students</h4>
        <p class="mb-0">View and manage students</p>
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
                <h5 class="card-title">{{ $student->name }}</h5>
            </div>
            <div class="col-lg-6 text-end">
                <a class="me-3 text-muted" type="button" data-bs-toggle="tooltip"
                    data-bs-title="Created at: {{ $student->created_at }}">
                    <i class="ri-timer-2-line"></i> {{ $student->created_at->diffForHumans() }}
                </a>
                <a class="text-muted" type="button" data-bs-toggle="tooltip"
                    data-bs-title="Updated at: {{ $student->updated_at }}">
                    <i class="ri-progress-5-line"></i> {{ $student->updated_at->diffForHumans() }}
                </a>
            </div>
        </div>
        <div class="info-container">
            <ul class="list-unstyled mb-6">
                <li class="mb-2">
                    <span class="h6 me-1">ID:</span>
                    <span>#{{ $student->student_number }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">Nationality:</span>
                    <span>{{ $student->nationality->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">Program:</span>
                    <span>{{ $student->program->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">Name:</span>
                    <span>{{ $student->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">Registration date:</span>
                    <span>{{ $student->date_from }} -> {{ $student->date_to }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">Gender:</span>
                    <span class="badge bg-label-info rounded-pill">{{ $student->gender_text }}</span>
                </li>
                <li class="mb-2">
                    <span class="h6 me-1">Status:</span>
                    @if ($student->is_active)
                    <span class="badge bg-label-success rounded-pill">Active</span>
                    @else
                    <span class="badge bg-label-danger rounded-pill">Inactive</span>
                    @endif
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
