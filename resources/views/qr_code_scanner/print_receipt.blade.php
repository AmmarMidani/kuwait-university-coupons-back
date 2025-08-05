<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Receipt #{{ $survey->id }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            font-family: 'Consolas', monospace;
            color: #000;
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 20px;
            direction: rtl;
            width: 100%;
        }

        .header,
        .footer {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .line {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }

        .row {
            margin-bottom: 6px;
            display: flex;
            justify-content: space-between;
        }

        .label {
            font-weight: bold;
        }

        @media print {
            body {
                padding: 0;
                margin: 0;
                width: 100%;
            }

            .line {
                border-top: 1px dashed #000;
            }

            .no-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="header">
        <div>{{ trans('website.food_hub') }}</div>
        <div>{{ trans('website.kuwait_university') }}</div>
    </div>

    <div class="line"></div>

    <div class="content">
        <div class="row">
            <span class="label">{{ trans('website.student_number') }}:</span>
            <span>{{ $survey->student->student_number }}</span>
        </div>
        <div class="row">
            <span class="label">{{ trans('website.student_name') }}:</span>
            <span>{{ $survey->student->name }}</span>
        </div>
        <div class="row">
            <span class="label">{{ trans('website.meal_type') }}:</span>
            <span>{{ $survey->meal->name }}</span>
        </div>
        <div class="row">
            <span class="label">{{ trans('website.merchant') }}:</span>
            <span>{{ $survey->user->name }}</span>
        </div>
        <div class="row">
            <span class="label">{{ trans('website.date') }}:</span>
            <span>{{ \Carbon\Carbon::now()->format('Y-m-d H:i') }}</span>
        </div>
    </div>

    <div class="line"></div>

    <div class="footer">
        {{ trans('website.thank_you') ?? 'شكراً لتعاونكم' }}
    </div>

    <script>
        window.onload = function () {
            window.print();
        };
    </script>
</body>

</html>
