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

    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style type="text/tailwindcss">
        @layer utilities {
            .scrollbar-hide::-webkit-scrollbar {
                display: none;
            }
            .scrollbar-hide {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }
        }
        .label {
            @apply block text-sm font-semibold text-gray-700 mb-1;
        }

        .input {
            @apply w-full rounded-lg border-gray-300 focus:ring-orange-300 focus:border-orange-400;
        }
    </style>

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
