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
        <p class="mb-0">Create new student</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-4">
        <!-- action buttons -->
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h5 class="card-tile mb-0">Student information</h5>
            </div>
            <div class="card-body">

                <form id="my-form" action="{{ route('student.update', $student) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="row">
                        <div class="col-sm-4 mb-3">
                            <div class="form-floating form-floating-outline">
                                {{ html()
                                ->select('program_id', $programs, $student->program_id)
                                ->class('form-select select2')
                                }}
                                <label>Program</label>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="form-floating form-floating-outline">
                                {{ html()
                                ->select('gender', $genders, $student->gender)
                                ->class('form-select select2')
                                }}
                                <label>Gender</label>
                            </div>
                        </div>
                        <div class="col-sm-4 mb-3">
                            <div class="form-floating form-floating-outline">
                                {{ html()
                                ->select('nationality_id', $nationalities, $student->nationality_id)
                                ->class('form-select select2')
                                }}
                                <label>Nationality</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="name" class="form-control" placeholder="Enter Name"
                                    value="{{ $student->name }}">
                                <label for="name">Name</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="student_number" class="form-control"
                                    placeholder="Enter Student Number" value="{{ $student->student_number }}">
                                <label for="student_number">Student Number</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="password" name="password" class="form-control"
                                    placeholder="Enter Password">
                                <label for="password">Password</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="password" name="password_confirmation" class="form-control"
                                    placeholder="Enter Password Confirmation">
                                <label for="password_confirmation">Password Confirmation</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input class="datepicker form-control" name="date_from"
                                    value="{{ $student->date_from }}" />
                                <label for="date_from">Date From</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input class="datepicker form-control" name="date_to" value="{{ $student->date_to }}" />
                                <label for="date_to">Date To</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-check form-switch mb-2">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" @if ($student->is_active) checked @endif value="1"
                                class="form-check-input" name="is_active" id="is_active">

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

    const date = new Date();

    $(".datepicker").flatpickr({
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
            program_id: {
				required: true,
			},
            gender: {
				required: true,
			},
            nationality_id: {
				required: true,
			},
            student_number: {
				required: true,
			},
            name: {
				required: true,
				minlength: 3,
			},
			password: {
				required: false,
				minlength: 8,
			},
            password_confirmation: {
				required: false,
				minlength: 8,
                equalTo: $('input[name="password"]'),
            },
            date_from: {
				required: true,
			},
            date_to: {
				required: true,
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
