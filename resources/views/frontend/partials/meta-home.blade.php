
    <title>{{ $title ?? ($webSetting->site_name ?? config('app.name')) }}</title>
    <meta name="description" content="{{ $description ?? $webSetting->site_description }}">
    <meta name="keywords" content="{{ $keywords ?? $webSetting->site_keywords }}">
    <meta name="author" content="{{ $author ?? $webSetting->site_author }}">
    <meta name="copyright" content="{{ $copyright ?? $webSetting->site_copyright }}">
    <meta name="url" content="{{ url()->current() }}">
    <meta name="og:site_name" content="{{ $title ?? ($webSetting->site_name ?? config('app.name')) }}">
    <meta name="og:title" content="{{ $title ?? ($webSetting->site_name ?? config('app.name')) }}">
    <meta name="og:description" content="{{ $description ?? $webSetting->site_description }}">
    <meta name="og:image" content="{{ $favicon ?? asset('storage/setting/' . $webSetting->site_logo) }}">
    <meta name="og:type" content="website">
    <meta name="og:url" content="{{ url()->current() }}">
