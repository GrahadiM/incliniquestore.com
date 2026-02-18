@extends('layouts.frontend')

@push('meta')
    @php
        $title = 'Check Out';
        $description = 'Check Out';
        $keywords = 'Check Out';
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
                <a href="{{ route('frontend.cart.index') }}" class="hover:text-primary-orange">Cart</a>
                <span class="mx-2">/</span>
                <span class="text-gray-700 font-medium">Check Out</span>
            </nav>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- LEFT --}}
                <div class="lg:col-span-2 space-y-6">

                    {{-- PRODUCTS --}}
                    <div class="bg-white p-5 border shadow-sm">
                        <h3 class="font-bold text-lg mb-4">Daftar Item</h3>
                        @if ($cartItems->count())
                            @foreach ($cartItems as $item)
                                <div class="flex justify-between py-2 border-b gap-2">
                                    <span>{{ $item->product->name }} × {{ $item->qty }}</span>
                                    <span id="item-total-{{ $item->id }}" class="font-semibold">Rp{{ number_format($item->qty * $item->product->price, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-10">
                                <p class="text-gray-500 mb-4">Keranjang kosong</p>
                                <a href="{{ route('frontend.shop.index') }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-primary-orange text-white font-semibold hover:bg-orange-700 transition">
                                    <i class="fas fa-shopping-cart"></i> Mulai Belanja
                                </a>
                            </div>
                        @endif
                    </div>

                    {{-- ADDRESS --}}
                    <div class="bg-white p-5 border shadow-sm">
                        <h3 class="font-bold text-lg mb-4">Alamat Pengiriman</h3>
                        @if ($addresses->count())
                            @foreach ($addresses as $addr)
                                <label
                                    class="block border p-4 mb-3 cursor-pointer hover:border-primary-orange transition">
                                    <input type="radio" name="address_id" value="{{ $addr->id }}" class="mr-2">
                                    <strong>{{ $addr->label }}</strong>
                                    <p class="text-sm text-gray-600">{{ $addr->address }}, {{ $addr->city }}</p>
                                </label>
                            @endforeach
                        @else
                            <div class="text-center py-2 flex flex-col items-center space-y-4">
                                <p class="text-gray-500">Belum ada alamat pengiriman!</p>
                                <a href="{{ route('customer.address.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-orange text-white font-semibold hover:bg-orange-700 transition">
                                    <i class="fas fa-plus"></i> Tambah Alamat
                                </a>
                            </div>
                        @endif
                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="space-y-6">
                    <div class="sticky top-20 space-y-6">
                        {{-- VOUCHER --}}
                        <div class="bg-white p-5 border shadow-sm">
                            <input id="voucher" class="border p-2 w-full" placeholder="Kode Voucher">
                            <button onclick="applyVoucher()" class="mt-3 w-full bg-black text-white py-2 hover:bg-gray-800 transition">
                                Gunakan Voucher
                            </button>
                        </div>

                        {{-- SUMMARY --}}
                        <div class="bg-white p-5 border shadow-sm">
                            <h3 class="text-lg font-bold border-b border-gray-300 pb-2 mb-4">Detail Pembayaran</h3>

                            <div class="space-y-3">
                                <div class="flex justify-between">
                                    <span>Subtotal</span>
                                    <span id="subtotal">
                                        Rp{{ number_format($subtotal, 0, ',', '.') }}
                                    </span>
                                </div>

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

                                <div id="discountRow" class="hidden flex justify-between text-red-500">
                                    <span>Diskon</span><span id="discount"></span>
                                </div>

                                <hr class="border-b border-gray-300">

                                <div class="flex justify-between font-bold text-lg">
                                    <span>Total Pembayaran</span><span id="grandTotal">Rp{{ number_format($total, 0, ',', '.') }}</span>
                                </div>
                            </div>

                            <button onclick="checkout()" class="mt-4 w-full bg-primary-orange text-white py-3 hover:bg-orange-700 transition">
                                Bayar Sekarang
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Midtrans Snap --}}
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    {{-- SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        let discount = 0;
        const subtotal = {{ $subtotal }};
        const tax = {{ $tax }};
        const shipping = {{ $shipping }};

        function rupiah(n) {
            return 'Rp' + n.toLocaleString('id-ID');
        }

        function updateTotal() {
            document.getElementById('grandTotal').innerText = rupiah(subtotal + tax + shipping - discount);
        }

        function applyVoucher() {
            const voucherCode = document.getElementById('voucher').value.trim();
            if (!voucherCode) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Voucher Kosong',
                    text: 'Silahkan masukkan kode voucher terlebih dahulu',
                    confirmButtonColor: '#f97316'
                });
                return;
            }

            fetch('{{ route('frontend.checkout.voucher') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    voucher: voucherCode
                })
            })
            .then(r => r.json())
            .then(res => {
                if (res.valid) {
                    discount = res.type === 'percent' ? subtotal * res.value / 100 : res.value;
                    document.getElementById('discount').innerText = '-' + rupiah(discount);
                    document.getElementById('discountRow').classList.remove('hidden');
                    updateTotal();
                    Swal.fire({
                        icon: 'success',
                        title: 'Voucher Berlaku',
                        text: `Diskon sebesar ${res.type === 'percent' ? res.value+'%' : rupiah(res.value)} berhasil digunakan`,
                        timer: 1500,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Voucher Tidak Valid',
                        text: res.message || 'Cek kode voucher anda',
                        confirmButtonColor: '#f97316'
                    });
                }
            });
        }

        // CHECKOUT
        function checkout() {
            const address = document.querySelector('input[name=address_id]:checked');
            if (!address) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Alamat Kosong',
                    text: 'Silahkan pilih atau tambah alamat pengiriman terlebih dahulu',
                    confirmButtonColor: '#f97316'
                });
                return;
            }

            fetch('{{ route('frontend.checkout.store') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    address_id: address.value,
                    voucher_code: document.getElementById('voucher').value
                })
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    snap.pay(res.snap_token, {
                        onSuccess: function(result){
                            window.location.href = "{{ route('customer.orders.index') }}";
                        },
                        onPending: function(result){
                            window.location.href = "{{ route('customer.orders.index') }}";
                        },
                        onError: function(result){
                            Swal.fire({
                                icon: 'error',
                                title: 'Pembayaran Gagal',
                                text: 'Terjadi kesalahan, silahkan coba lagi',
                                confirmButtonColor: '#ef4444'
                            });
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Checkout',
                        text: res.message || 'Terjadi kesalahan',
                        confirmButtonColor: '#ef4444'
                    });
                }
            });
        }
    </script>
@endsection
