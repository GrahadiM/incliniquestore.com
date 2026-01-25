@extends('layouts.frontend')

@section('title', 'Berita & Artikel')

@section('content')
<section class="py-16 bg-primary-light">
    <div class="w-full lg:max-w-7xl mx-auto px-4">

        {{-- Header --}}
        <div class="mb-12 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                Berita & Artikel
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan berita terbaru, tips kecantikan, dan informasi menarik seputar produk kami.
            </p>
        </div>

        {{-- News Grid --}}
        @if($data->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($data as $news)
                    @include('frontend.partials.news-card', ['news' => $news])
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-16">
                {{ $data->links('pagination::tailwind') }}
            </div>
        @else
            <div class="text-center text-gray-500 py-20">
                Belum ada berita yang tersedia.
            </div>
        @endif

    </div>
</section>
@endsection
