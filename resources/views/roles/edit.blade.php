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
        <p class="mb-0">{{ __('website.update_roles_permissions_details') }}</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-4">
        <!-- action buttons -->
    </div>
</div>

<form id="my-form" action="{{ route('role.update', $role) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('put')
    <div class="row mb-4">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-tile mb-0">{{ __('website.roles_permissions_information') }}</h5>
                </div>
                <div class="card-body">

                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="name" class="form-control"
                                    placeholder="{{ __('website.enter_name') }}" value="{{ $role->name }}">
                                <label for="name">{{ __('website.name') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="description" class="form-control"
                                    placeholder="{{ __('website.enter_description') }}"
                                    value="{{ $role->description }}">
                                <label for="description">{{ __('website.description') }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="row text-end">
                        <div class="col-sm-12 mb-3">
                            <a href="javascript:void(0);" class="fw-medium" id="btn_select_all">{{
                                __('website.select_all') }}</a> /
                            <a href="javascript:void(0);" class="fw-medium" id="btn_select_none">{{
                                __('website.select_none') }}</a>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success submit">{{ __('website.save') }}</button>

                </div>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach ($permissions as $group => $items)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center flex-wrap ">
                        <div>
                            <h6 class="text-primary fw-bold mb-3">
                                {{ ucwords(str_replace('_', ' ', $group)) }}
                            </h6>
                        </div>
                        <div class="d-flex align-items-center flex-wrap text-nowrap">
                            <a href="javascript:void(0);" data-table="{{ $group }}"
                                class="fw-medium ms-2 btn_cm_select_all">{{ __('website.all') }}</a>
                            <a href="javascript:void(0);" data-table="{{ $group }}"
                                class="fw-medium ms-2 btn_cm_select_none">{{ __('website.none') }}</a>
                        </div>
                    </div>

                    @foreach ($items as $permission)
                    <div class="form-check mb-2">
                        <input type="checkbox" class="form-check-input" name="permissions[]" {{
                            $selected_roles->contains($permission->name) ? 'checked' : '' }}
                        value="{{ $permission->name }}" data-table="{{ $group }}" id="{{ $permission->name }}">
                        <label class="form-check-label" for="{{ $permission->name }}">{{ $permission->description
                            }}</label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
    </div>
</form>

@endsection

@section('js_plugin')
<script src="{{ asset('assets/vendor/libs/jquery-validation/jquery.validate.min.js') }}?v={{ config('app.version') }}">
</script>
@endsection

@section('js')
<script>
    $(document).ready(function () {

    $('#btn_select_all').click(function (e) {
        $("#my-form input:checkbox").prop('checked', true);
    });

    $('#btn_select_none').click(function (e) {
        $("#my-form input:checkbox").prop('checked', false);
    });

    $('#my-form .btn_cm_select_all').click(function (e) {
        console.log('btn_cm_select_all');
        var $btn = $(this);
        var table_name = $btn.data('table');
        $(`#my-form input[type=checkbox][data-table="${table_name}"]`).prop('checked', true);
    });

    $('#my-form .btn_cm_select_none').click(function (e) {
        var $btn = $(this);
        var table_name = $btn.data('table');
        $(`#my-form input[type=checkbox][data-table="${table_name}"]`).prop('checked', false);
    });

    $.validator.addMethod("regex",
        function (value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );

	$("#my-form").validate({
		rules: {
            name: {
				required: true,
				minlength: 3,
			},
            description: {
				required: false,
			},
		},
		messages: {
			// name: {
			//     required: "Please enter a name",
			//     minlength: "Name must consist of at least 3 characters"
			// },
			// email: "Please enter a valid email address",
			// age_select: "Please select your age",
			// skill_check: "Please select your skills",
			// gender_radio: "Please select your gender",
			// password: {
			//     required: "Please provide a password",
			//     minlength: "Your password must be at least 5 characters long"
			// },
			// confirm_password: {
			//     required: "Please confirm your password",
			//     minlength: "Your password must be at least 5 characters long",
			//     equalTo: "Please enter the same password as above"
			// },
			// terms_agree: "Please agree to terms and conditions"
		},
		errorPlacement: function (error, element) {
			error.addClass("invalid-feedback");
			if (element.parent('.input-group').length) {
				error.insertAfter(element.parent());
			}
			else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
				error.insertAfter(element.parent().parent());
			}
			else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
				error.appendTo(element.parent().parent());
			}
			else if (element.prop('type') === 'select') {
                console.log(element);
			}
			else if (element.prop('type') === 'select-multiple') {
				error.insertAfter(element.parent());
			}
			else {
				error.insertAfter(element.parent());
			}
		},
		highlight: function (element, errorClass) {
			if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
				$(element).addClass("is-invalid").removeClass("is-valid");
			}
		},
		unhighlight: function (element, errorClass) {
			if ($(element).prop('type') != 'checkbox' && $(element).prop('type') != 'radio') {
				$(element).addClass("is-valid").removeClass("is-invalid");
			}
		}
	});
});
</script>
@endsection
