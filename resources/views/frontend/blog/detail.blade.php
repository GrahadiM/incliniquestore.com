@extends('layouts.frontend')

@push('meta')
    @php
        $title = $data->meta_title ?? $data->title;
        $description = $data->meta_description ?? $data->title;
        $keywords = $data->meta_keywords ?? $data->title;
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
                <a href="{{ route('frontend.blog.index') }}" class="hover:text-primary-orange">Blog</a>
                <span class="mx-2">/</span>
                <span class="text-gray-700 font-medium">{{ $data->title }}</span>
            </nav>

            {{-- Title --}}
            <h1 class="text-3xl font-bold text-gray-800 mb-4 leading-snug">
                {{ $data->title }}
            </h1>

            {{-- Meta --}}
            <div class="flex flex-wrap items-center text-sm text-gray-500 mb-8 gap-4">
                <div class="flex items-center space-x-2">
                    <i class="fas fa-user"></i>
                    <span>{{ $data->author?->name ?? 'Admin' }}</span>
                </div>

                <div class="flex items-center space-x-2">
                    <i class="fas fa-calendar"></i>
                    <span>{{ $data->created_at->format('d M Y') }}</span>
                </div>

                <div class="flex items-center space-x-2">
                    <i class="fas fa-eye"></i>
                    <span>{{ number_format($data->views) }} views</span>
                </div>
            </div>

            {{-- Thumbnail --}}
            <div class="mb-10">
                <img
                    src="{{ config('app.asset_url') . '/storage/' . $data->thumbnail }}"
                    alt="{{ $data->meta_title ?? $data->title }}"
                    class="w-full rounded-br-[32px] rounded-tl-[32px] object-cover max-h-[500px]">
            </div>

            {{-- Content --}}
            <article class="prose prose-lg max-w-none prose-headings:text-gray-800 prose-p:text-gray-700">
                {!! $data->content !!}
            </article>

            {{-- Back Button --}}
            <div class="mt-16 text-center">
                <a href="{{ route('frontend.blog.index') }}"
                class="inline-block bg-primary-orange text-white px-6 py-3 rounded-br-[16px] rounded-tl-[16px] font-medium hover:shadow-lg hover:shadow-orange-500/50 transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Berita
                </a>
            </div>
        </div>
    </section>
@endsection
