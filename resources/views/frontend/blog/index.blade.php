@extends('layouts.frontend')

@push('meta')
    @php
        $title = 'Blog';
        $description = 'Blog';
        $keywords = 'Blog';
    @endphp
    @include('frontend.partials.meta-home')
@endpush

@section('content')
    <section class="bg-white py-10 md:py-16">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Breadcrumb --}}
            <nav class="text-sm text-gray-500 mb-6">
                <a href="{{ route('frontend.index') }}" class="hover:text-primary-orange">Home</a>
                <span class="mx-2">/</span>
                <span class="text-gray-700 font-medium">Blog</span>
            </nav>

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
