@extends('layouts.frontend')

@section('title', 'Keranjang Belanja')

@section('content')
<section class="py-8 md:py-16 bg-primary-light">
    <div class="w-full lg:max-w-7xl mx-auto px-4">

        {{-- Header --}}
        <div class="mb-8 md:mb-12 text-center">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 md:mb-4">
                Keranjang Belanja
            </h1>
            <p class="text-sm md:text-base text-gray-600 max-w-2xl mx-auto">
                Periksa kembali produk yang telah Anda pilih sebelum melanjutkan ke checkout.
            </p>
        </div>

        @if ($data->count())
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 md:gap-8">

            {{-- CART ITEMS --}}
            <div class="lg:col-span-2">
                {{-- Header Table (Desktop) --}}
                <div class="hidden md:grid grid-cols-12 gap-4 mb-4 px-4 text-sm text-gray-600 font-medium">
                    <div class="col-span-5">Produk</div>
                    <div class="col-span-2 text-center">Harga</div>
                    <div class="col-span-2 text-center">Total</div>
                    <div class="col-span-2 text-center">Jumlah</div>
                    <div class="col-span-1 text-center">Aksi</div>
                </div>

                {{-- Cart Items --}}
                <div class="space-y-4 md:space-y-3">
                    @foreach ($data as $item)
                    <div
                        class="bg-white rounded-xl shadow-sm p-4 md:p-4 grid grid-cols-12 gap-3 md:gap-4 items-center"
                        id="cart-item-{{ $item->id }}"
                    >
                        {{-- Kolom 1: Gambar & Nama Produk (Mobile: full width) --}}
                        <div class="col-span-12 md:col-span-5 flex items-center gap-3 md:gap-4">
                            <img
                                src="{{ config('app.asset_url') . '/storage/' . $item->product->thumbnail }}"
                                alt="{{ $item->product->name }}"
                                class="w-16 h-16 md:w-20 md:h-20 object-cover rounded-lg border"
                            >
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-800 text-sm md:text-base line-clamp-2">
                                    {{ $item->product->name }}
                                </h3>
                                {{-- Harga per item (hanya tampil di mobile) --}}
                                <div class="md:hidden mt-1">
                                    <p class="text-sm text-gray-500">
                                        Rp.{{ number_format($item->product->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        </div>

                        {{-- Kolom 2: Harga per Item (Desktop only) --}}
                        <div class="hidden md:flex md:col-span-2 justify-center">
                            <p class="text-gray-800 font-medium">
                                Rp.{{ number_format($item->product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Kolom 3: Total Harga --}}
                        <div class="col-span-4 md:col-span-2">
                            <div class="md:hidden text-xs text-gray-500 mb-1">Total</div>
                            <p
                                class="font-bold text-gray-800 text-sm md:text-base text-right md:text-center"
                                id="item-total-{{ $item->id }}"
                            >
                                Rp.{{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Kolom 4: Quantity Control --}}
                        <div class="col-span-5 md:col-span-2">
                            <div class="md:hidden text-xs text-gray-500 mb-1">Jumlah</div>
                            <div class="flex items-center justify-end md:justify-center gap-2">
                                <button
                                    class="qty-btn w-7 h-7 md:w-8 md:h-8 border rounded-lg hover:bg-gray-100 flex items-center justify-center transition"
                                    data-id="{{ $item->id }}"
                                    data-action="decrease"
                                    aria-label="Kurangi jumlah"
                                >−</button>

                                <span
                                    class="min-w-[28px] text-center font-semibold text-sm md:text-base"
                                    id="qty-{{ $item->id }}"
                                >
                                    {{ $item->qty }}
                                </span>

                                <button
                                    class="qty-btn w-7 h-7 md:w-8 md:h-8 border rounded-lg hover:bg-gray-100 flex items-center justify-center transition"
                                    data-id="{{ $item->id }}"
                                    data-action="increase"
                                    aria-label="Tambah jumlah"
                                >+</button>
                            </div>
                        </div>

                        {{-- Kolom 5: Aksi (Delete) --}}
                        <div class="col-span-3 md:col-span-1">
                            <div class="flex justify-end md:justify-center">
                                <button
                                    class="remove-cart-item w-7 h-7 md:w-8 md:h-8 border rounded-lg hover:bg-red-50 text-red-500 hover:text-red-700 flex items-center justify-center transition"
                                    data-id="{{ $item->id }}"
                                    aria-label="Hapus item"
                                    title="Hapus dari keranjang"
                                >
                                    <i class="fas fa-trash text-xs md:text-sm"></i>
                                </button>
                            </div>
                        </div>

                        {{-- Divider untuk mobile --}}
                        <div class="col-span-12 md:hidden border-t pt-3 mt-3">
                            <div class="flex justify-between items-center">
                                <div class="text-sm text-gray-600">
                                    Harga Satuan:
                                    <span class="font-medium">
                                        Rp.{{ number_format($item->product->price, 0, ',', '.') }}
                                    </span>
                                </div>
                                <button
                                    class="remove-cart-item text-sm text-red-500 hover:text-red-700 flex items-center gap-1"
                                    data-id="{{ $item->id }}"
                                >
                                    <i class="fas fa-trash"></i>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- SUMMARY (STICKY) --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-xl shadow-sm p-5 md:p-6 h-fit sticky top-24">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 md:mb-6">
                        Ringkasan Belanja
                    </h3>

                    <div class="space-y-3 md:space-y-4">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal</span>
                            <strong id="cart-subtotal" class="text-gray-800 text-lg">
                                Rp.{{ number_format($subtotal, 0, ',', '.') }}
                            </strong>
                        </div>

                        @if($tax > 0)
                        <div class="flex justify-between text-gray-600">
                            <span>Pajak</span>
                            <span id="tax" class="text-gray-800">Rp.{{ number_format($tax, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        @if($shipping > 0)
                        <div class="flex justify-between text-gray-600">
                            <span>Ongkos Kirim</span>
                            <span id="shipping" class="text-gray-800">Rp.{{ number_format($shipping, 0, ',', '.') }}</span>
                        </div>
                        @endif

                        <div class="border-t pt-3 md:pt-4">
                            <div class="flex justify-between text-gray-800 font-bold text-lg mb-4">
                                <span>Total</span>
                                <span id="cart-total">Rp.{{ number_format($total, 0, ',', '.') }}</span>
                            </div>

                            <a
                                href="{{ route('frontend.checkout.index') }}"
                                class="block w-full text-center bg-primary text-white py-3 rounded-lg font-semibold hover:bg-primary-dark transition mb-3"
                            >
                                Lanjut ke Checkout
                            </a>

                            <a
                                href="{{ route('frontend.product.index') }}"
                                class="block w-full text-center border border-gray-300 text-gray-700 py-3 rounded-lg font-medium hover:bg-gray-50 transition"
                            >
                                Lanjutkan Belanja
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        @else
            {{-- EMPTY CART --}}
            <div class="text-center py-12 md:py-20">
                <div class="inline-flex items-center justify-center w-20 h-20 md:w-24 md:h-24 rounded-full bg-gray-100 mb-6">
                    <i class="fas fa-shopping-cart text-3xl md:text-4xl text-gray-400"></i>
                </div>
                <p class="text-gray-500 mb-6 text-lg">
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

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @media (max-width: 768px) {
            .sticky {
                position: static;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        /**
         * Format Rupiah
         */
        function formatRupiah(number) {
            return 'Rp.' + Number(number).toLocaleString('id-ID');
        }

        /**
         * UPDATE QTY
         */
        document.querySelectorAll('.qty-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const cartId = this.dataset.id;
                const action = this.dataset.action;

                const qtyEl = document.getElementById(`qty-${cartId}`);
                const totalEl = document.getElementById(`item-total-${cartId}`);

                let qty = parseInt(qtyEl.innerText);
                const oldQty = qty;

                if (action === 'increase') qty++;
                if (action === 'decrease' && qty > 1) qty--;

                if (qty === oldQty) return;

                // Disable buttons sementara
                document
                    .querySelectorAll(`.qty-btn[data-id="${cartId}"]`)
                    .forEach(b => b.disabled = true);

                fetch(`{{ route('frontend.cart.update', ':id') }}`.replace(':id', cartId), {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ qty })
                })
                .then(res => {
                    if (!res.ok) throw new Error('Gagal update qty');
                    return res.json();
                })
                .then(data => {
                    if (!data.success) throw new Error(data.message);

                    // Update qty & item total
                    qtyEl.innerText = data.qty;
                    totalEl.innerText = formatRupiah(data.item_total);

                    // Update ringkasan
                    const subtotalEl = document.getElementById('cart-subtotal');
                    if (subtotalEl) subtotalEl.innerText = formatRupiah(data.subtotal);

                    const taxEl = document.getElementById('tax');
                    if (taxEl) taxEl.innerText = formatRupiah(data.tax || 0);

                    const shippingEl = document.getElementById('shipping');
                    if (shippingEl) shippingEl.innerText = formatRupiah(data.shipping || 0);

                    const totalElSummary = document.getElementById('cart-total');
                    if (totalElSummary) totalElSummary.innerText = formatRupiah(data.total);

                    // Update cart badge (jika ada)
                    if (typeof updateCartBadge === 'function') {
                        updateCartBadge(data.cart_count);
                    }
                })
                .catch(err => {
                    qtyEl.innerText = oldQty;
                    alert(err.message || 'Terjadi kesalahan');
                })
                .finally(() => {
                    document
                        .querySelectorAll(`.qty-btn[data-id="${cartId}"]`)
                        .forEach(b => b.disabled = false);
                });
            });
        });

        /**
         * REMOVE ITEM
         */
        document.querySelectorAll('.remove-cart-item').forEach(btn => {
            btn.addEventListener('click', function () {
                const cartId = this.dataset.id;

                if (!confirm('Hapus item dari keranjang?')) return;

                fetch(`{{ route('frontend.cart.destroy', ':id') }}`.replace(':id', cartId), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(res => {
                    if (!res.ok) throw new Error('Gagal menghapus item');
                    return res.json();
                })
                .then(data => {
                    if (!data.success) throw new Error(data.message);

                    document.getElementById(`cart-item-${cartId}`)?.remove();

                    const subtotalEl = document.getElementById('cart-subtotal');
                    if (subtotalEl) subtotalEl.innerText = formatRupiah(data.subtotal);

                    const taxEl = document.getElementById('tax');
                    if (taxEl) taxEl.innerText = formatRupiah(data.tax || 0);

                    const shippingEl = document.getElementById('shipping');
                    if (shippingEl) shippingEl.innerText = formatRupiah(data.shipping || 0);

                    const totalElSummary = document.getElementById('cart-total');
                    if (totalElSummary) totalElSummary.innerText = formatRupiah(data.total);

                    if (typeof updateCartBadge === 'function') {
                        updateCartBadge(data.cart_count);
                    }

                    // Jika cart kosong → reload ke empty state
                    if (!document.querySelector('[id^="cart-item-"]')) {
                        location.reload();
                    }
                })
                .catch(err => alert(err.message || 'Terjadi kesalahan'));
            });
        });
    </script>
@endpush
