<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    @stack('meta')

    <!-- Favicon -->
    <link rel="icon" href="{{ $webSetting->favicon ? asset('favicon.ico') : asset('storage/setting/' . $webSetting->logo) }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ $webSetting->favicon ? asset('favicon.ico') : asset('storage/setting/' . $webSetting->logo) }}" type="image/x-icon">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    @if (env('APP_ENV') === 'local')
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    @include('frontend.partials.css')

    <!-- Custom Styles CSS -->
    @stack('styles')

</head>
<body class="bg-white scrollbar-hide">

    @include('frontend.partials.header')

    <main>
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    @include('frontend.partials.navbar-mobile')

    @include('frontend.partials.js')

    <!-- Custom Scripts JS -->
    @stack('scripts')

</body>
</html>
