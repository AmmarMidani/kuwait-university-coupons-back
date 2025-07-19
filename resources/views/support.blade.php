<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <title>{{ config('app.name', 'Laravel') }} | Support</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon/favicon.png') }}?v={{ config('app.version') }}" />

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f8f9fa;
        }

        header {
            background-color: #007aff;
            color: white;
            padding: 20px;
            text-align: center;
        }

        main {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background: white;
        }

        h1,
        h2 {
            color: #333;
        }

        .faq {
            margin-bottom: 30px;
        }

        .faq h3 {
            margin-top: 15px;
            color: #007aff;
        }

        footer {
            text-align: center;
            font-size: 14px;
            padding: 20px;
            background: #f1f1f1;
        }

        a {
            color: #007aff;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <header>
        <h1>KUNIV – Support</h1>
    </header>

    <main>
        <section>
            <h2>About KUNIV</h2>
            <p>
                KUNIV is a simple app designed to help students at Kuwait University organize their daily meals and
                replace physical meal coupons with a convenient digital version.
            </p>
        </section>

        <section class="faq">
            <h2>Frequently Asked Questions</h2>

            <h3>How do I get my digital meal coupon?</h3>
            <p>Once you log in, your daily meal coupon will automatically appear on the home screen. Just show it when
                receiving your meal.</p>

            <h3>Why is my meal coupon not showing?</h3>
            <p>Please ensure you're connected to the internet and logged in with your correct student credentials. If
                the issue continues, contact our support team.</p>

            <h3>Can I use the app without an internet connection?</h3>
            <p>No, the app requires an active internet connection to verify your coupon each day.</p>
        </section>

        <section>
            <h2>Contact Support</h2>
            <p>Need help? Reach out to us at: <a href="mailto:{{ $email }}">{{ $email }}</a></p>
        </section>

        <footer>
            &copy; 2025 KUNIV App Team. All rights reserved.
        </footer>
</body>

</html>
