@extends('layouts.app')

@section('pagename')
Nationalities
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">Nationalities</h4>
        <p class="mb-0">Create new nationality</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-4">
        <!-- action buttons -->
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h5 class="card-tile mb-0">Nationality information</h5>
            </div>
            <div class="card-body">

                <form id="my-form" action="{{ route('nationality.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                    value="{{ old('name') }}">
                                <label for="name">Name</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-check form-switch mb-2">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" class="form-check-input" value="1" name="is_active" checked
                                    id="is_active">
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success submit">Save</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection

@section('js_plugin')
<script src="{{ asset('assets/vendor/libs/jquery-validation/jquery.validate.min.js') }}?v={{ config('app.version') }}">
</script>
@endsection

@section('js')
<script>
    $(document).ready(function () {
    $(".select2").select2();

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
