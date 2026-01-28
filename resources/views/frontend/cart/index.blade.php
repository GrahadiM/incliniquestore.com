@extends('layouts.frontend')

@section('title', 'Keranjang Belanja')

@section('content')
<section class="py-16 bg-primary-light">
    <div class="w-full lg:max-w-7xl mx-auto px-4">

        {{-- Header --}}
        <div class="mb-12 text-center">
            <h1 class="text-3xl font-bold text-gray-800 mb-4">
                Keranjang Belanja
            </h1>
            <p class="text-gray-600 max-w-2xl mx-auto">
                Periksa kembali produk yang telah Anda pilih sebelum melanjutkan ke checkout.
            </p>
        </div>

        {{-- Cart Content --}}
        @if ($data->count())

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                {{-- Cart Items --}}
                <div class="lg:col-span-2 space-y-6">
                    @foreach ($data as $item)
                        <div class="flex gap-6 bg-white rounded-xl shadow-sm p-4">

                            {{-- Thumbnail --}}
                            <img
                                src="{{ config('app.asset_url') . '/storage/' . $item->product->thumbnail }}"
                                alt="{{ $item->product->name }}"
                                class="w-24 h-24 object-cover rounded-lg border"
                            >

                            {{-- Info --}}
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-800 text-sm">
                                    {{ $item->product->name }}
                                </h3>

                                <p class="text-sm text-gray-500 mt-1">
                                    Rp {{ number_format($item->product->price) }}
                                </p>

                                {{-- Qty --}}
                                <div class="mt-4 flex items-center gap-4">
                                    <span class="text-sm text-gray-600">
                                        Qty: <strong>{{ $item->qty }}</strong>
                                    </span>
                                </div>
                            </div>

                            {{-- Total --}}
                            <div class="text-right">
                                <p class="text-sm text-gray-500 mb-1">
                                    Total
                                </p>
                                <p class="font-bold text-gray-800">
                                    Rp {{ number_format($item->product->price * $item->qty) }}
                                </p>
                            </div>

                        </div>
                    @endforeach
                </div>

                {{-- Summary --}}
                <div class="bg-white rounded-xl shadow-sm p-6 h-fit">
                    <h3 class="text-lg font-semibold text-gray-800 mb-6">
                        Ringkasan Belanja
                    </h3>

                    <div class="flex justify-between text-gray-600 mb-4">
                        <span>Subtotal</span>
                        <strong class="text-gray-800">
                            Rp {{ number_format($subtotal) }}
                        </strong>
                    </div>

                    <div class="border-t pt-4">
                        <a
                            href="{{ route('frontend.checkout.index') }}"
                            class="block w-full text-center bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition"
                        >
                            Lanjut ke Checkout
                        </a>
                    </div>
                </div>

            </div>

        @else
            {{-- Empty Cart --}}
            <div class="text-center py-20">
                <p class="text-gray-500 mb-6">
                    Keranjang Anda masih kosong.
                </p>
                <a
                    href="{{ route('frontend.product.index') }}"
                    class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-dark transition"
                >
                    Mulai Belanja
                </a>
            </div>
        @endif

    </div>
</section>
@endsection
