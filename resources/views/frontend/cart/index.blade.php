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
                <div class="bg-white rounded-xl shadow-sm p-5 md:p-6 h-fit sticky-summary">
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
                                href="{{ route('frontend.shop.index') }}"
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
                    href="{{ route('frontend.shop.index') }}"
                    class="inline-block bg-primary text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-dark transition"
                >
                    Mulai Belanja
                </a>
            </div>
        @endif

    </div>
</section>
@endsection

@push('scripts')
    <script>
        /**
         * Format Rupiah
         */
        function formatRupiah(number) {
            return 'Rp.' + Number(number).toLocaleString('id-ID');
        }

        /**
         * UPDATE QTY dengan loading state
         */
        document.querySelectorAll('.qty-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const cartId = this.dataset.id;
                const action = this.dataset.action;
                const qtyEl = document.getElementById(`qty-${cartId}`);
                let qty = parseInt(qtyEl.innerText);

                if (action === 'increase') qty++;
                if (action === 'decrease' && qty > 1) qty--;

                // Disable buttons sementara
                const buttons = document.querySelectorAll(`.qty-btn[data-id="${cartId}"]`);
                buttons.forEach(b => b.disabled = true);

                // Tampilkan loading
                const originalHTML = qtyEl.innerHTML;
                qtyEl.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch(`{{ route('frontend.cart.update', ':id') }}`.replace(':id', cartId), {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ qty })
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        throw new Error(data.message || 'Gagal update qty');
                    }
                    return data;
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }

                    // Update tampilan
                    qtyEl.textContent = data.qty;
                    document.getElementById(`item-total-${cartId}`).textContent = formatRupiah(data.item_total);

                    // Update ringkasan
                    updateCartSummary(data);

                    // Update cart badge
                    if (window.updateCartBadge) {
                        updateCartBadge(data.cart_count);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message);
                    // Kembalikan ke nilai sebelumnya
                    fetchCartItem(cartId);
                })
                .finally(() => {
                    buttons.forEach(b => b.disabled = false);
                });
            });
        });

        /**
         * REMOVE ITEM
         */
        document.querySelectorAll('.remove-cart-item').forEach(btn => {
            btn.addEventListener('click', function () {
                const cartId = this.dataset.id;
                const cartItem = document.getElementById(`cart-item-${cartId}`);

                if (!confirm('Hapus item dari keranjang?')) return;

                // Tampilkan loading
                cartItem.classList.add('opacity-50');
                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';

                fetch(`{{ route('frontend.cart.destroy', ':id') }}`.replace(':id', cartId), {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                })
                .then(async res => {
                    const data = await res.json();
                    if (!res.ok) {
                        throw new Error(data.message || 'Gagal menghapus item');
                    }
                    return data;
                })
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Terjadi kesalahan');
                    }

                    // Hapus elemen
                    cartItem.remove();

                    // Update ringkasan
                    updateCartSummary(data);

                    // Update cart badge
                    if (window.updateCartBadge) {
                        updateCartBadge(data.cart_count);
                    }

                    // Jika cart kosong, reload halaman
                    if (!document.querySelector('[id^="cart-item-"]')) {
                        setTimeout(() => location.reload(), 1000);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(error.message);
                    cartItem.classList.remove('opacity-50');
                    this.disabled = false;
                    this.innerHTML = '<i class="fas fa-trash"></i>';
                });
            });
        });

        /**
         * Fungsi helper untuk update ringkasan
         */
        function updateCartSummary(data) {
            const elements = {
                subtotal: document.getElementById('cart-subtotal'),
                tax: document.getElementById('tax'),
                shipping: document.getElementById('shipping'),
                total: document.getElementById('cart-total')
            };

            Object.keys(elements).forEach(key => {
                if (elements[key] && data[key] !== undefined) {
                    elements[key].textContent = formatRupiah(data[key]);
                }
            });
        }

        /**
         * Fungsi untuk fetch data item terbaru
         */
        function fetchCartItem(cartId) {
            fetch(`{{ route('frontend.cart.index') }}`)
                .then(res => res.json())
                .then(data => {
                    // Update hanya item yang sesuai
                    const item = data.data.find(item => item.id == cartId);
                    if (item) {
                        document.getElementById(`qty-${cartId}`).textContent = item.qty;
                        document.getElementById(`item-total-${cartId}`).textContent =
                            formatRupiah(item.product.price * item.qty);
                    }
                })
                .catch(console.error);
        }

        /**
         * Handle error response dengan lebih baik
         */
        function handleResponseError(response) {
            return response.json().then(data => {
                const error = new Error(data.message || 'Terjadi kesalahan');
                error.data = data;
                throw error;
            });
        }
    </script>
@endpush

@push('styles')
    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        /* Animasi untuk update */
        @keyframes highlightUpdate {
            0% { background-color: rgba(34, 197, 94, 0.2); }
            100% { background-color: transparent; }
        }

        .updated {
            animation: highlightUpdate 1s ease-out;
        }

        /* Responsive untuk sticky summary */
        @media (min-width: 1024px) {
            .sticky-summary {
                position: sticky;
                top: 6rem;
                align-self: flex-start;
            }
        }
    </style>
@endpush
