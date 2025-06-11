<div class="card border h-100 bg-success-subtle border-success">
    <div class="card-header">
        <h5 class="card-tile mb-0">Student Details</h5>
        <p class="text-muted">Related student details</p>
    </div>
    <div class="card-body">
        <div class="user-info text-center">
            <h5 class="mb-0">{{ $student->name }}</h5>
            <span class="text-muted">#{{ $student->student_number }}</span>
        </div>
        <h5 class="pb-4 border-bottom mb-4">Details</h5>
        <div class="info-container">
            <ul class="list-unstyled mb-6">
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">Nationality:</span>
                    <span>{{ $student->nationality->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">Program:</span>
                    <span>{{ $student->program->name }}</span>
                </li>
                <li class="mb-2">
                    <span class="fw-medium text-heading me-2">Gender:</span>
                    <span>{{ $student->gender_text }}</span>
                </li>
            </ul>
        </div>
        @can('qr_code_scanner_add')
        <div class="d-flex justify-content-center">
            <div class="d-flex justify-content-center">
                <button type="button" class="btn btn-success me-4 waves-effect waves-light"
                    id="btn-accept-meal">Accept</button>
                <button type="button" class="btn btn-outline-danger suspend-user waves-effect"
                    id="btn-reject-meal">Reject</button>
            </div>
        </div>
        @else
        <div class="text-danger text-center">
            {{ __('website.need_permission') }}
        </div>
        @endcan
    </div>
</div>
