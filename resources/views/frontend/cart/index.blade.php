@extends('layouts.frontend')

@section('title', 'Keranjang Belanja')

@section('content')
    <section class="py-8 md:py-16 bg-primary-light">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Header --}}
            <div class="mb-8 text-center">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">
                    Keranjang Belanja
                </h1>
                <p class="text-gray-600">
                    Periksa kembali produk sebelum checkout
                </p>
            </div>

            @if ($data->count())
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- CART ITEMS --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach ($data as $item)
                    <div
                        id="cart-item-{{ $item->id }}"
                        class="bg-white p-4 rounded-xl shadow-sm grid grid-cols-12 gap-4 items-center"
                    >
                        {{-- PRODUCT --}}
                        <div class="col-span-12 md:col-span-5 flex gap-4">
                            <img
                                src="{{ config('app.asset_url') . '/storage/' . $item->product->thumbnail }}"
                                class="w-20 h-20 object-cover rounded-lg border"
                            >
                            <div>
                                <h3 class="font-semibold text-gray-800">
                                    {{ $item->product->name }}
                                </h3>
                                <p class="text-sm text-gray-500">
                                    Rp.{{ number_format($item->product->price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- ITEM TOTAL --}}
                        <div class="col-span-6 md:col-span-2 text-center font-semibold"
                            id="item-total-{{ $item->id }}">
                            Rp.{{ number_format($item->product->price * $item->qty, 0, ',', '.') }}
                        </div>

                        {{-- QTY --}}
                        <div class="col-span-6 md:col-span-2">
                            <div class="flex justify-center items-center gap-2">
                                <button
                                    class="qty-btn border w-8 h-8 rounded"
                                    data-id="{{ $item->id }}"
                                    data-action="decrease"
                                >−</button>

                                <span
                                    id="qty-{{ $item->id }}"
                                    data-stock="{{ $item->product->stock }}"
                                    class="w-8 text-center font-semibold"
                                >
                                    {{ $item->qty }}
                                </span>

                                <button
                                    class="qty-btn border w-8 h-8 rounded"
                                    data-id="{{ $item->id }}"
                                    data-action="increase"
                                >+</button>
                            </div>
                        </div>

                        {{-- REMOVE --}}
                        <div class="col-span-12 md:col-span-1 text-center">
                            <button
                                class="remove-cart-item text-red-500 hover:text-red-700"
                                data-id="{{ $item->id }}"
                            >
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- SUMMARY --}}
                <div>
                    <div class="bg-white p-6 rounded-xl shadow-sm sticky top-24">
                        <h3 class="text-lg font-bold mb-4">Ringkasan</h3>

                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span>Subtotal</span>
                                <strong id="cart-subtotal">
                                    Rp.{{ number_format($subtotal, 0, ',', '.') }}
                                </strong>
                            </div>

                            <div class="flex justify-between">
                                <span>Pajak</span>
                                <span id="tax">
                                    Rp.{{ number_format($tax, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="flex justify-between">
                                <span>Ongkir</span>
                                <span id="shipping">
                                    Rp.{{ number_format($shipping, 0, ',', '.') }}
                                </span>
                            </div>

                            <hr>

                            <div class="flex justify-between font-bold text-lg">
                                <span>Total</span>
                                <span id="cart-total">
                                    Rp.{{ number_format($total, 0, ',', '.') }}
                                </span>
                            </div>

                            <a
                                href="{{ route('frontend.checkout.index') }}"
                                class="block w-full text-center bg-primary text-white py-3 rounded-lg mt-4"
                            >
                                Checkout
                            </a>
                        </div>
                    </div>
                </div>

            </div>
            @else
                <div class="text-center py-20">
                    <p class="text-gray-500 mb-4">Keranjang kosong</p>
                    <a href="{{ route('frontend.shop.index') }}" class="btn-primary">
                        Mulai Belanja
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

                // VALIDASI STOCK FRONTEND
                if (action === 'increase' && qty >= stock) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Stok Tidak Cukup',
                        text: `Stok tersedia hanya ${stock}`,
                        confirmButtonColor: '#f97316'
                    });
                    return;
                }

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
                    document.getElementById(`item-total-${cartId}`)
                        .textContent = rupiah(data.item.item_total);

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
