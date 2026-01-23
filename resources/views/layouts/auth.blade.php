<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .card {
            transition: transform 0.3s ease;
        }

        .form-control:focus {
            border-color: #0077b6;
            box-shadow: 0 0 0 0.25rem rgba(102, 126, 234, 0.25);
        }

        .btn-primary {
            background: linear-gradient(135deg, #0077b6 0%, #00b4d8 100%);
            border: none;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .input-group-text {
            transition: all 0.3s ease;
        }

        .form-control:focus+.input-group-text {
            border-color: #0077b6;
        }

        #togglePassword:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body class="">
    @yield('content')

    @stack('scripts')
</body>
</html>