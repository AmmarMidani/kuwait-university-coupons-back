@extends('layouts.app')

@section('pagename')
{{ __('website.qr_code_scanner') }}
@endsection

@section('css_plugin')
@endsection

@section('css')
<style>
    .qr-code-scan {
        width: 300px;
        height: 300px;
        border: 2px dashed #ccc;
        border-radius: 8px;
        cursor: pointer;
    }

    .qr-input-hiddent {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }
</style>
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">{{ __('website.qr_code_scanner') }}</h4>
        <p class="mb-0">{{ __('website.meal_distribution_and_qr_code_scanning') }}</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-4">
        <!-- action buttons -->
    </div>
</div>

<div class="row mb-4">
    <div class="col-6">
        <div class="card h-100">
            <div class="card-header">
                <h5 class="card-tile mb-0">{{ __('website.qr_code_reader') }}</h5>
            </div>
            <div class="card-body d-flex flex-column align-items-center justify-content-center">
                <div id="qr-box" class="d-flex align-items-center justify-content-center mb-3 qr-code-scan">
                    <i class="ri-qr-code-line" style=" font-size: 240px;"></i>
                </div>

                <p class="text-muted">{{ __('website.click_the_icon_to_start_scan') }}</p>
                <input type="text" id="qr-input" class="form-control qr-input-hiddent" autocomplete="off">
            </div>
        </div>
    </div>
    @can('qr_code_scanner_add')
    <div class="col-6" id="student-details">
        {!! $init_card !!}
    </div>
    @else
    <div class="col-6">
        <div class="text-danger text-center">
            {{ __('website.need_permission') }}
        </div>
    </div>
    @endcan
</div>
@endsection

@section('js_plugin')
@endsection

@section('js')
<script>
    'use strict';

(function () {
    const $input = $('#qr-input');

    function handleScan(value) {
        if (!value.trim()) return;

        $.ajax({
            url: '{{ route("qr-code-scanner.verify") }}',
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                qr_code: value.trim()
            },
            success: function (response) {
                $('#student-details').html(response.html);
                if (response.status) {
                    window.open(response.print_receipt_url, '_blank');
                }
            },
            error: function () {
                $('#student-details').html('<p class="text-danger">{{ __("website.something_went_wrong_try_again_later") }}</p>');
            },
        });
    }

    $('#qr-box').on('click', function () {
        $input.val('').focus();
    });

    // Handle Enter key press (simulate scan)
    $input.on('keypress', function (e) {
        if (e.which === 13) {
            handleScan($input.val());
        }
    });

    // Delegate Accept/Reject actions
    $(document).on('click', '#btn-reject-meal', function () {
        $.get('{{ route("qr-code-scanner.index") }}', function (response) {
            const html = $(response).find('#student-details').html();
            $('#student-details').html(html);
        });
    });

    $(document).on('click', '#btn-accept-meal', function () {
        $.ajax({
            url: '{{ route("qr-code-scanner.store") }}',
            method: 'POST',
            data: {
                '_token': '{{ csrf_token() }}',
                qr_code: $input.val(),
            },
            success: function (response) {
                $('#student-details').html(response.html);
            },
            error: function () {
                Swal.fire('{{ __("website.error") }}', '{{ __("website.failed_to_record_meal") }}', 'error');
            }
        });
    });

})();
</script>
@endsection
