<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Layanan Informasi')</title>
    <link rel="icon" href="{{ asset('image/logo BNN.png') }}" type="image/jpeg">

    {{-- Tailwind CSS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .main-content {
            margin-top: 0px; 
        }
    </style>
</head>
<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col m-0 p-0 overflow-x-hidden">
 @include('components.user.header')

    {{-- Main Content --}}
    <main class="main-content w-full p-0 m-0 flex-grow">
        @yield('content')
    </main>

    {{-- Footer --}}
    @include('components.user.footer')

    @yield('scripts')
</body>
</html>
