<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
        }
    </style>
</head>

<body class="d-flex flex-column min-vh-100">
    <x-navbar />

    <main class="d-flex flex-grow-1 overflow-hidden">
        <!-- Main Content Area -->
        <div class="flex-grow-1 bg-secondary bg-opacity-25" style="overflow-y: auto; overflow-x: hidden; min-width: 0;">
            @yield('content')
        </div>
    </main>

    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    @if (session('success'))
    <script type="module">
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: "{{ session('success') }}",
            confirmButtonText: 'OK'
        });
    </script>
    @endif
    @if (session('error'))
    <script type="module">
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: "{{ session('error') }}",
            confirmButtonText: 'OK'
        });
    </script>
    @endif
</body>

</html>
