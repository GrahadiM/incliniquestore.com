@extends('layouts.frontend')

@push('meta')
    @php
        $title = 'Cart';
        $description = 'Cart';
        $keywords = 'Cart';
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
                <span class="text-gray-700 font-medium">Cart</span>
            </nav>

            @if ($data->count())
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                    {{-- CART ITEMS --}}
                    <div class="lg:col-span-2 space-y-4">
                        @foreach ($data as $item)
                            <div id="cart-item-{{ $item->id }}" class="bg-white border border-gray-300 rounded-sm p-2 shadow-sm grid grid-cols-12 gap-4 items-center">
                                {{-- PRODUCT --}}
                                <div class="col-span-12 md:col-span-7 flex gap-2">
                                    <img
                                        src="{{ config('app.asset_url') . '/storage/' . $item->product->thumbnail }}"
                                        class="w-20 h-20 object-cover rounded-sm border hover:cursor-pointer"
                                        alt="{{ $item->product->name }}"
                                        onclick="window.location.href='{{ route('frontend.shop.detail', $item->product->slug) }}';"
                                    >
                                    <div>
                                        <h3 class="font-semibold line-clamp-2 text-gray-800 hover:cursor-pointer" onclick="window.location.href='{{ route('frontend.shop.detail', $item->product->slug) }}';">
                                            {{ $item->product->name }}
                                        </h3>
                                        <div class="grid grid-cols-1 md:grid-cols-12 justify-between items-center">
                                            <span class="md:col-span-8 text-sm text-green-600 font-medium inline-flex items-center gap-1">
                                                <i class="fas fa-check-circle"></i>
                                                Stok tersedia ({{ $item->product->stock }})
                                            </span>
                                            <br class="hidden md:block">
                                            <span class="md:col-span-4 text-sm text-gray-500">
                                                Rp.{{ number_format($item->product->price, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-12 md:col-span-5 grid grid-cols-6">
                                    <hr class="md:hidden col-span-12 border border-b border-gray-300 mb-2">

                                    {{-- QTY --}}
                                    <div class="col-span-2">
                                        <div class="flex justify-center items-center gap-2">
                                            <button
                                                class="qty-btn text-white bg-primary-orange border border-primary-orange hover:bg-orange-700 w-8 h-8 rounded-md"
                                                data-id="{{ $item->id }}"
                                                data-action="decrease"
                                            >
                                                <i class="fas fa-minus"></i>
                                            </button>

                                            <span
                                                id="qty-{{ $item->id }}"
                                                data-stock="{{ $item->product->stock }}"
                                                class="w-8 text-center font-semibold"
                                            >
                                                {{ $item->qty }}
                                            </span>

                                            <button
                                                class="qty-btn text-white bg-primary-orange border border-primary-orange hover:bg-orange-700 w-8 h-8 rounded-md"
                                                data-id="{{ $item->id }}"
                                                data-action="increase"
                                            >
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>

                                    {{-- ITEM TOTAL --}}
                                    <div class="col-span-3 text-center font-semibold"
                                        id="item-total-{{ $item->id }}">
                                        Rp.{{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                                    </div>

                                    {{-- REMOVE --}}
                                    <div class="col-span-1 text-center">
                                        <button
                                            class="remove-cart-item text-white bg-red-500 hover:bg-red-700 border border-gray-300 w-8 h-8 rounded-md"
                                            data-id="{{ $item->id }}"
                                        >
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- SUMMARY --}}
                    <div>
                        <div class="bg-white border border-gray-300 rounded-sm p-4 shadow-sm sticky top-24">
                            <h3 class="text-lg font-bold border-b border-gray-300 pb-2 mb-4">Detail Pembayaran</h3>

                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span>Biaya Pajak (10%)</span>
                                    <span id="tax">
                                        Rp.{{ number_format($tax, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span>Biaya Pengiriman</span>
                                    <span id="shipping">
                                        Rp.{{ number_format($shipping, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="flex justify-between">
                                    <span>Subtotal</span>
                                    <span id="cart-subtotal">
                                        Rp.{{ number_format($subtotal, 0, ',', '.') }}
                                    </span>
                                </div>

                                <hr class="border-b border-gray-300">

                                <div class="flex justify-between font-bold text-lg">
                                    <span>Total Pembayaran</span>
                                    <span id="cart-total">
                                        Rp.{{ number_format($total, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <a
                                href="{{ route('frontend.checkout.index') }}"
                                class="block w-full text-center font-semibold bg-orange-500 text-white py-3 hover:bg-orange-700 hover:shadow-lg hover:shadow-orange-500/50 transition duration-300 mt-6"
                            >
                                <i class="fas fa-receipt mr-2"></i>
                                Check Out
                            </a>
                        </div>
                    </div>

                </div>
            @else
                <div class="flex flex-col items-center justify-center py-16 space-y-6">
                    <h2 class="text-2xl font-bold text-gray-800">Keranjang Anda Kosong</h2>
                    <p class="text-gray-500 text-justify max-w-lg">
                        Sepertinya Anda belum menambahkan produk apapun ke keranjang.
                        Mulai jelajahi produk kami dan temukan produk yang Anda inginkan!
                    </p>

                    <a href="{{ route('frontend.shop.index') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-primary-orange text-white font-semibold rounded-lg shadow hover:bg-orange-700 transition duration-300">
                        <i class="fas fa-shopping-cart"></i> Mulai Belanja
                    </a>
                </div>
            @endif

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function rupiah(n) {
            return 'Rp.' + Number(n).toLocaleString('id-ID');
        }

        /**
         * UPDATE QTY (+ / -)
         */
        document.querySelectorAll('.qty-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                const cartId = this.dataset.id;
                const action = this.dataset.action;

                const qtyEl = document.getElementById(`qty-${cartId}`);
                const stock = parseInt(qtyEl.dataset.stock);
                let qty = parseInt(qtyEl.textContent);

                // VALIDASI STOCK FRONTEND === 0
                if (action === 'increase' && stock === 0) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Stok Sudah Habis',
                        text: 'Silahkan pilih produk lain',
                        confirmButtonColor: '#f97316'
                    });
                    return;
                }
                // VALIDASI STOCK FRONTEND == QTY
                if (action === 'increase' && qty == stock) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Stok Tidak Cukup',
                        text: `Jumlah stok yang tersedia tersisa ${stock} item`,
                        confirmButtonColor: '#f97316'
                    });
                    return;
                }

                // VALIDASI STOCK FRONTEND > QTY
                // if (action === 'increase' && qty > stock) {
                //     Swal.fire({
                //         icon: 'warning',
                //         title: 'Stok Tidak Cukup',
                //         text: `Stok tersedia hanya ${stock}`,
                //         confirmButtonColor: '#f97316'
                //     });
                //     return;
                // }

                if (action === 'increase') qty++;
                if (action === 'decrease' && qty > 1) qty--;

                // Disable button sementara
                const buttons = document.querySelectorAll(`.qty-btn[data-id="${cartId}"]`);
                buttons.forEach(b => b.disabled = true);

                qtyEl.innerHTML = `<i class="fas fa-spinner fa-spin text-gray-400"></i>`;

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
                    if (!res.ok || !data.success) {
                        throw new Error(data.message || 'Gagal update jumlah');
                    }
                    return data;
                })
                .then(data => {
                    // UPDATE ITEM
                    qtyEl.textContent = data.item.qty;
                    document.getElementById(`item-total-${cartId}`).textContent = rupiah(data.item.item_total);

                    // UPDATE SUMMARY
                    document.getElementById('cart-subtotal').textContent = rupiah(data.subtotal);
                    document.getElementById('tax').textContent = rupiah(data.tax);
                    document.getElementById('shipping').textContent = rupiah(data.shipping);
                    document.getElementById('cart-total').textContent = rupiah(data.total);

                    // Update badge cart (jika ada)
                    if (window.updateCartBadge) {
                        updateCartBadge(data.cart_count);
                    }
                })
                .catch(err => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: err.message,
                        confirmButtonColor: '#ef4444'
                    });
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

                Swal.fire({
                    title: 'Hapus Produk?',
                    text: 'Produk akan dihapus dari keranjang',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, hapus',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#9ca3af'
                }).then(result => {
                    if (!result.isConfirmed) return;

                    cartItem.classList.add('opacity-50');

                    fetch(`{{ route('frontend.cart.destroy', ':id') }}`.replace(':id', cartId), {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                    .then(async res => {
                        const data = await res.json();
                        if (!res.ok || !data.success) {
                            throw new Error(data.message || 'Gagal menghapus item');
                        }
                        return data;
                    })
                    .then(data => {
                        Swal.fire({
                            icon: 'success',
                            title: 'Dihapus',
                            text: 'Produk berhasil dihapus',
                            timer: 1200,
                            showConfirmButton: false
                        });

                        cartItem.remove();

                        // Update summary
                        document.getElementById('cart-subtotal').textContent = rupiah(data.subtotal);
                        document.getElementById('tax').textContent = rupiah(data.tax);
                        document.getElementById('shipping').textContent = rupiah(data.shipping);
                        document.getElementById('cart-total').textContent = rupiah(data.total);

                        if (window.updateCartBadge) {
                            updateCartBadge(data.cart_count);
                        }

                        // Jika cart kosong → reload
                        if (!document.querySelector('[id^="cart-item-"]')) {
                            setTimeout(() => location.reload(), 1000);
                        }
                    })
                    .catch(err => {
                        cartItem.classList.remove('opacity-50');
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: err.message,
                            confirmButtonColor: '#ef4444'
                        });
                    });
                });
            });
        });
    </script>
@endpush
