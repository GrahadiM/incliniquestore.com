@extends('layouts.frontend')

@push('meta')
    @php
        $title = 'Riwayat Pesanan - Dashboard Customer';
        $description = 'Lihat riwayat pesanan Anda, status pembayaran, total transaksi, dan detail setiap order.';
        $keywords = 'riwayat pesanan, order, customer dashboard, belanja online';
    @endphp
    @include('frontend.partials.meta-home')
@endpush

@section('content')
    <section class="bg-gray-50 py-10 md:py-16">
        <div class="max-w-7xl mx-auto px-4">

            {{-- HEADER --}}
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    Riwayat Pesanan
                </h1>
                <p class="text-gray-500 mt-1">
                    Kelola data pesanan Anda, cek status pembayaran, dan lihat detail setiap transaksi yang pernah Anda lakukan.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                {{-- SIDEBAR --}}
                @include('customer.partials.sidebar')

                {{-- MAIN CONTENT --}}
                <main class="lg:col-span-3 space-y-6">

                    {{-- ORDER LIST --}}
                    <div class="bg-white rounded-md shadow p-4 md:p-6">
                        <h2 class="text-lg md:text-xl font-semibold text-gray-800 mb-4">
                            Semua Pesanan Anda
                        </h2>

                        <div class="overflow-x-auto">
                            <table id="orderTable" class="w-full text-sm md:text-base" aria-label="Tabel riwayat pesanan">
                                <thead class="bg-gray-50 text-gray-600 uppercase text-xs md:text-sm tracking-wider">
                                    <tr>
                                        <th class="py-2 px-3">#</th>
                                        <th class="py-2 px-3">No Order</th>
                                        <th class="py-2 px-3">Status</th>
                                        <th class="py-2 px-3">Total</th>
                                        <th class="py-2 px-3">Tanggal</th>
                                        <th class="py-2 px-3">Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </main>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <script>
        $(function() {
            $('#orderTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('customer.orders.datatable') }}",
                order: [[4, 'desc']], // urut berdasarkan tanggal
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'order_number', name: 'order_number' },
                    {
                        data: 'status',
                        name: 'status',
                        render: function(status) {
                            switch(status) {
                                case 'unpaid': return '<span class="text-yellow-600 font-medium">Unpaid</span>';
                                case 'paid': return '<span class="text-blue-600 font-medium">Paid</span>';
                                case 'processed': return '<span class="text-indigo-600 font-medium">Processed</span>';
                                case 'shipped': return '<span class="text-purple-600 font-medium">Shipped</span>';
                                case 'completed': return '<span class="text-green-600 font-medium">Completed</span>';
                                case 'cancelled': return '<span class="text-red-600 font-medium">Cancelled</span>';
                                default: return '<span class="text-gray-600 font-medium">' + status + '</span>';
                            }
                        }
                    },
                    {
                        data: 'grand_total',
                        name: 'grand_total',
                    },
                    {
                        data: 'created_at',
                        name: 'created_at',
                        render: function(data) {
                            if (!data) return '-';
                            const dt = new Date(data);

                            const time = dt.toLocaleTimeString('id-ID', {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false,
                                timeZone: 'Asia/Jakarta'
                            });

                            const date = dt.toLocaleDateString('id-ID', {
                                day: '2-digit',
                                month: 'long',
                                year: 'numeric',
                                timeZone: 'Asia/Jakarta'
                            });

                            return `${time}, ${date}`;
                        }
                    },
                    { data: 'action', orderable: false, searchable: false }
                ],
                createdRow: function(row) {
                    $(row).addClass('hover:bg-gray-50 transition duration-150');
                },
                language: {
                    processing: "Sedang memproses...",
                    search: "Cari:",
                    lengthMenu: "Tampilkan _MENU_ data",
                    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty: "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered: "(disaring dari _MAX_ data keseluruhan)",
                    loadingRecords: "Memuat...",
                    zeroRecords: "Tidak ada data yang cocok",
                    emptyTable: "Tidak ada data tersedia di tabel",
                    paginate: {
                        first: "Pertama",
                        previous: "Sebelumnya",
                        next: "Berikutnya",
                        last: "Terakhir"
                    },
                    aria: {
                        sortAscending: ": aktifkan untuk mengurutkan kolom secara naik",
                        sortDescending: ": aktifkan untuk mengurutkan kolom secara turun"
                    }
                }
            });
        });
    </script>
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('services.midtrans.clientKey') }}"></script>
    <script>
        function payOrder(orderId) {
            $.post("{{ url('/customer/orders') }}/" + orderId + "/payment-token", {
                _token: "{{ csrf_token() }}"
            }, function(res) {
                snap.pay(res.token, {
                    onSuccess: function(result){
                        alert('Pembayaran berhasil!');
                        location.reload(); // refresh halaman agar status berubah
                    },
                    onPending: function(result){
                        alert('Pembayaran menunggu konfirmasi.');
                        location.reload();
                    },
                    onError: function(result){
                        alert('Terjadi kesalahan pada pembayaran.');
                    },
                    onClose: function(){
                        console.log('Popup ditutup.');
                    }
                });
            });
        }
    </script>
@endpush
