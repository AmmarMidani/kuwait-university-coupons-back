<div class="card h-100">
    <div class="card-header">
        <h5 class="card-tile mb-0">Student Details</h5>
        <p class="text-muted">Related student details</p>
    </div>
    <div class="card-body d-flex flex-column align-items-center justify-content-center">
        @isset($message)
        <p class="text-success">{{ $message }}</p>
        @endisset
        <p>Start scan to see details</p>
    </div>
</div>
