@extends('layouts.frontend')

@section('content')
<section class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- ADDRESS --}}
        <div class="border rounded-lg p-4">
            <h3 class="font-bold mb-2">Alamat Pengiriman</h3>
            <select id="address" class="w-full border rounded p-2">
                @foreach($addresses as $a)
                    <option value="{{ $a->id }}">
                        {{ $a->label }} - {{ $a->city }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- VOUCHER --}}
        <div class="border rounded-lg p-4">
            <h3 class="font-bold mb-2">Voucher</h3>
            <input id="voucher" class="border p-2 w-full" placeholder="Kode Voucher">
        </div>

    </div>

    {{-- RIGHT --}}
    <div class="border rounded-lg p-4">
        <button id="payBtn"
            class="w-full bg-primary-orange text-white py-3 rounded font-bold">
            Bayar Sekarang
        </button>
    </div>

</section>
@endsection

@push('scripts')
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script>
        document.getElementById('payBtn').onclick = async function () {

            const res = await fetch('{{ route("frontend.checkout.store") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    address_id: document.getElementById('address').value,
                    voucher_code: document.getElementById('voucher').value
                })
            });

            const data = await res.json();

            const snap = await fetch(`/payment/snap/${data.order_id}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            const snapData = await snap.json();

            snap.pay(snapData.snap_token);
        };
    </script>
@endpush
