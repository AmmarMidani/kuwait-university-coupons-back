@extends('layouts.app')

@section('pagename')
{{ __('website.meal_prices') }}
@endsection

@section('css_plugin')
@endsection

@section('css')
@endsection

@section('content')
<div
    class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-6 row-gap-4">
    <div class="d-flex flex-column justify-content-center">
        <h4 class="mb-1">{{ __('website.meal_prices') }}</h4>
        <p class="mb-0">{{ __('website.create_new_meal_price') }}</p>
    </div>
    <div class="d-flex align-content-center flex-wrap gap-4">
        <!-- action buttons -->
    </div>
</div>

<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-header">
                <h5 class="card-tile mb-0">{{ __('website.meal_price_information') }}</h5>
            </div>
            <div class="card-body">
                <form id="my-form" action="{{ route('meal-price.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                {{ html()
                                ->select('meal_id', $meals, old('meal_id'))
                                ->class('form-select select2')
                                }}
                                <label>{{ __('website.meal') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                {{ html()
                                ->select('user_id', $users, old('user_id'))
                                ->class('form-select select2')
                                }}
                                <label>{{ __('website.user') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input class="datepicker form-control" name="effective_date"
                                    value="{{ old('effective_date') }}" />
                                <label for="effective_date">{{ __('website.effective_date') }}</label>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="form-floating form-floating-outline">
                                <input type="text" name="price" class="form-control touchSpin" placeholder="{{ __('website.enter_price') }}"
                                    value="{{ old('price') }}">
                                <label for="price">{{ __('website.price') }}</label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success submit">{{ __('website.save') }}</button>
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

    $(".datepicker").flatpickr({});

    $(".touchSpin").TouchSpin({
        initval: 0,
        min: 0,
        step: 0.01,
        decimals: 2,
        boostat: 5,
        maxboostedstep: 10,
        verticalbuttons: true,
        // verticalupclass: 'glyphicon glyphicon-plus btn-inverse-success',
        // verticaldownclass: 'glyphicon glyphicon-minus btn-inverse-danger'
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
            meal_id: {
				required: true,
			},
            user_id: {
				required: true,
			},
            effective_date: {
				required: true,
			},
            price: {
				required: true,
                min: 0
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