<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="no-js">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <title>{{ config('app.name', 'Laravel') }} | Privacy Policy</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon/favicon.png') }}?v={{ config('app.version') }}" />

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            display: flex;
            min-height: 100vh;
            scroll-behavior: smooth;
        }

        nav {
            width: 250px;
            background-color: #f5f5f5;
            padding: 20px;
            border-right: 1px solid #ddd;
            position: fixed;
            height: 100%;
            overflow-y: auto;
        }

        nav h2 {
            font-size: 18px;
            color: #2c3e50;
            margin-bottom: 10px;
        }

        nav a {
            display: block;
            margin: 10px 0;
            color: #333;
            text-decoration: none;
            font-size: 14px;
        }

        nav a:hover {
            color: #007BFF;
        }

        main {
            margin-left: 270px;
            padding: 40px;
            max-width: 800px;
        }

        h1,
        h2 {
            color: #2c3e50;
        }
    </style>
</head>

<body>
    <nav>
        <h2>Navigation</h2>
        <a href="#info">1. Information We Collect</a>
        <a href="#usage">2. How We Use Your Information</a>
        <a href="#storage">3. Data Storage and Security</a>
        <a href="#thirdparty">4. Third-Party Services</a>
        <a href="#rights">5. Your Rights</a>
        <a href="#children">6. Children’s Privacy</a>
        <a href="#changes">7. Changes to This Policy</a>
        <a href="#contact">8. Contact Us</a>
    </nav>

    <main>
        <h1>Privacy Policy for KUNIV</h1>
        <p><strong>Effective Date:</strong> {{ $effective_date }}<br>
            <strong>Last Updated:</strong> {{ $last_updated }}
        </p>

        <h2 id="info">1. Information We Collect</h2>
        <ul>
            <li><strong>Student Login Credentials:</strong> Used only for authentication via Kuwait University's secure
                systems.</li>
            <li><strong>Meal Usage Data:</strong> Information about the meals you have received and upcoming
                eligibility.</li>
            <li><strong>QR Code Data:</strong> Linked to your meal eligibility and scanned at cafeterias.</li>
            <li><strong>Meal Ratings:</strong> Stored feedback for service improvement.</li>
        </ul>
        <p>We do <strong>not</strong> collect or store sensitive personal information such as national ID, payment info,
            or GPS location.</p>

        <h2 id="usage">2. How We Use Your Information</h2>
        <ul>
            <li>Verifying your identity and meal eligibility</li>
            <li>Displaying your meal history and upcoming meals</li>
            <li>Enabling the QR-based meal system</li>
            <li>Improving catering quality based on your feedback</li>
        </ul>
        <p>We do <strong>not</strong> sell or share your personal data with third parties.</p>

        <h2 id="storage">3. Data Storage and Security</h2>
        <p>All data is securely stored on Kuwait University servers or authorized systems. We apply strict access
            controls and encryption to protect your data from unauthorized access or misuse.</p>

        <h2 id="thirdparty">4. Third-Party Services</h2>
        <p>The app does <strong>not</strong> use third-party services or SDKs that collect your personal data.</p>

        <h2 id="rights">5. Your Rights</h2>
        <ul>
            <li>Request access to your data</li>
            <li>Report a privacy concern</li>
            <li>Request data removal (where applicable)</li>
        </ul>

        <h2 id="children">6. Children’s Privacy</h2>
        <p>This app is intended for use by university students aged 18 and above. It is not designed for children under
            13 years of age.</p>

        <h2 id="changes">7. Changes to This Policy</h2>
        <p>We may update this Privacy Policy from time to time. We encourage you to review this page periodically.</p>

        <h2 id="contact">8. Contact Us</h2>
        <p>If you have any questions or concerns about this Privacy Policy, please contact:</p>
        <p><strong>Kuwait University IT Department</strong><br>
            Email: {{ $email }}<br>
            Website: {{ $website }}</p>
    </main>

</body>

</html>
