@extends('layouts.frontend')

@section('title', 'Shop Product')

@section('content')
<section class="py-16 bg-primary-light">
    <div class="w-full lg:max-w-7xl mx-auto px-4">

        {{-- Header --}}
        <div class="mb-12 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                Shop Product
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Temukan berbagai produk terbaik kami yang dirancang untuk memenuhi kebutuhan Anda.
            </p>
        </div>

        {{-- Products Grid --}}
        @if($data->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($data as $product)
                    @include('frontend.partials.product-card', ['product' => $product])
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
