@extends('layouts.frontend')

@push('meta')
    @php
        $title = $data->meta_title ?? $data->name;
        $description = $data->meta_description ?? $data->name;
        $keywords = $data->meta_keywords ?? $data->name;
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
                <a href="{{ route('frontend.shop.index') }}" class="hover:text-primary-orange">Shop</a>
                <span class="mx-2">/</span>
                <a href="{{ route('frontend.shop.category.index', ['slug' => $data->category->slug]) }}" class="hover:text-primary-orange">{{ $data->category->name }}</a>
                <span class="mx-2">/</span>
                <span class="text-gray-700 font-medium">{{ $data->name }}</span>
            </nav>

            {{-- MAIN --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 p-2 md:p-4">

                {{-- LEFT: IMAGE --}}
                <div>
                    <div class="overflow-hidden rounded-tl-[12px] rounded-br-[12px] border mb-4">
                        <img
                            src="{{ config('app.asset_url') . '/storage/' . $data->thumbnail }}"
                            alt="{{ $data->name }}"
                            class="w-full aspect-square object-cover"
                            id="mainProductImage"
                        >
                    </div>

                    {{-- Thumbnails --}}
                    @if ($data->images?->count())
                    <div class="flex gap-3 overflow-x-auto">
                        <img
                            src="{{ config('app.asset_url') . '/storage/' . $data->thumbnail }}"
                            class="w-20 h-20 object-cover rounded-xl border cursor-pointer"
                            onclick="changeImage(this)"
                        >

                        @foreach ($data->images as $img)
                            <img
                                src="{{ config('app.asset_url') . '/storage/' . $img->image_path }}"
                                class="w-20 h-20 object-cover rounded-xl border cursor-pointer"
                                onclick="changeImage(this)"
                            >
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- RIGHT: INFO --}}
                <div class="flex flex-col">

                    <h1 class="text-xl md:text-2xl font-bold text-gray-800 mb-2">
                        {{ $data->name }}
                    </h1>

                    <div class="flex items-center gap-4 text-sm text-gray-500 mb-4">
                        <span class="flex items-center gap-1">
                            <i class="fas fa-list"></i>
                            {{ $data->category?->name }}
                        </span>
                        {{-- <span class="flex items-center gap-1">
                            <i class="fas fa-eye"></i>
                            {{ number_format($data->views) }} views
                        </span> --}}
                    </div>

                    {{-- PRICE --}}
                    <div class="mb-4">
                        <span class="text-xl md:text-2xl font-bold text-primary-red">
                            Rp {{ number_format($data->price, 0, ',', '.') }}
                        </span>
                    </div>

                    {{-- STOCK --}}
                    <div class="mb-4">
                        @if ($data->stock > 0)
                            <span class="inline-flex items-center gap-2 text-green-600 font-medium">
                                <i class="fas fa-check-circle"></i>
                                Stok tersedia ({{ $data->stock }})
                            </span>
                        @else
                            <span class="inline-flex items-center gap-2 text-red-500 font-medium">
                                <i class="fas fa-times-circle"></i>
                                Stok habis
                            </span>
                        @endif
                    </div>

                    {{-- QTY --}}
                    <div class="flex items-center gap-4 mb-4">
                        <span class="font-medium text-gray-700">Jumlah:</span>
                        <div class="flex items-center border rounded-lg overflow-hidden">
                            <button class="px-4 py-2" onclick="updateQty(-1)">−</button>
                            <input
                                type="number"
                                id="qty"
                                value="1"
                                min="1"
                                class="w-12 text-center outline-none border-0"
                                disabled
                            >
                            <button class="px-4 py-2" onclick="updateQty(1)">+</button>
                        </div>
                    </div>

                    {{-- CTA --}}
                    {{-- <div class="flex flex-col sm:flex-row gap-1 mt-auto"> --}}
                    <div class="flex flex-col sm:flex-row gap-1">
                        <button
                            onclick="addToCart({{ $data->id }}, event)"
                            class="flex-1 border border-primary-orange bg-primary-orange text-white text-sm font-semibold py-3 rounded-bl-[48px] rounded-tr-[48px] md:rounded-bl-[12px] md:rounded-tr-[12px] hover:bg-transparent hover:text-primary-orange transition flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-shopping-cart"></i>
                            Add to Cart
                        </button>

                        <a
                            href="{{ route('frontend.cart.index') }}"
                            class="flex-1 border border-primary-orange bg-primary-orange text-white text-sm font-semibold py-3 rounded-br-[48px] rounded-tl-[48px] md:rounded-br-[12px] md:rounded-tl-[12px] hover:bg-transparent hover:text-primary-orange transition flex items-center justify-center gap-2"
                        >
                            <i class="fas fa-shopping-bag"></i>
                            Checkout
                        </a>
                    </div>

                </div>
            </div>

            {{-- DESCRIPTION --}}
            <div class="p-2 md:p-4 mt-4">
                <h2 class="text-xl md:text-2xl font-bold text-gray-800 border-b-2 border-t-2 border-gray-500 pb-2 pt-2 mb-4">
                    Deskripsi Produk
                </h2>

                <article class="prose max-w-none prose-headings:text-gray-800 prose-p:text-gray-700">
                    {!! $data->description !!}
                </article>
            </div>

            {{-- RECOMMENDATIONS --}}
            @if($recommendations->count())
                <div class="p-2 md:p-4 mt-4">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-800 border-b-2 border-t-2 border-gray-500 pb-2 pt-2 mb-4">
                        Rekomendasi Produk
                    </h2>
                    <span class="text-xs bg-orange-100 text-primary-orange px-2 py-1 rounded-full inline-block mb-6">
                        Dipilih berdasarkan minat Anda
                    </span>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach ($recommendations as $item)
                            @include('frontend.partials.product-card', ['product' => $item])
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const MAX_STOCK = {{ $data->stock }};

        function changeImage(el) {
            document.getElementById('mainProductImage').src = el.src;
        }

        function updateQty(val) {
            const input = document.getElementById('qty');
            let qty = parseInt(input.value) || 1;

            qty += val;

            if (qty < 1) qty = 1;
            if (qty > MAX_STOCK) {
                qty = MAX_STOCK;
                alert('Jumlah melebihi stok yang tersedia!');
            }

            input.value = qty;
        }

        function getQty() {
            return parseInt(document.getElementById('qty').value) || 1;
        }

        function addToCart(productId, event) {
            event.preventDefault();

            const qty = getQty();

            fetch("{{ route('frontend.cart.add') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    product_id: productId,
                    qty: qty
                })
            })
            .then(res => res.json())
            .then(data => {
                if (!data.success) {
                    alert(data.message || 'Gagal menambahkan ke keranjang');
                    return;
                }

                alert('Produk berhasil ditambahkan!');
            });
        }
    </script>
@endpush
