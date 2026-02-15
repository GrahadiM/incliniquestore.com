@extends('layouts.frontend')

@push('meta')
    @php
        $title = 'Dashboard';
        $description = 'Dashboard Customer';
        $keywords = 'Dashboard';
    @endphp
    @include('frontend.partials.meta-home')
@endpush

@section('content')
    <section class="bg-gray-50 py-10 md:py-16">
        <div class="max-w-7xl mx-auto px-4">

            {{-- HEADER --}}
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    Dashboard
                </h1>
                <p class="text-gray-500 mt-1">
                    Selamat datang kembali, <span class="font-medium">{{ $user->name }}</span>
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                {{-- SIDEBAR --}}
                @include('customer.partials.sidebar')

                {{-- MAIN --}}
                <main class="lg:col-span-3 space-y-6">

                    {{-- ANALYTICS --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <x-dashboard.stat title="Total Pesanan" :value="$stats['total_orders']" icon="shopping-bag" />
                        <x-dashboard.stat title="Pesanan Aktif" :value="$stats['active_orders']" icon="truck" />
                        <x-dashboard.stat title="Selesai" :value="$stats['completed_orders']" icon="check-circle" />
                        <x-dashboard.stat title="Total Belanja" :value="'Rp '.number_format($stats['total_spent'],0,',','.')" icon="wallet" />
                    </div>

                    {{-- ORDER LIST --}}
                    {{-- <div class="bg-white rounded-md shadow p-4 md:p-6">
                        <h2 class="text-base md:text-lg font-semibold text-gray-800 mb-4">
                            Riwayat Pesanan
                        </h2>

                        <div class="overflow-x-auto -mx-4 md:mx-0">
                            <table id="orderTable" class="w-full text-xs md:text-sm">
                                <thead class="bg-gray-50 text-gray-600 whitespace-nowrap">
                                    <tr>
                                        <th>#</th>
                                        <th>No Order</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div> --}}
                </main>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: '{{ session('success') }}',
                timer: 3000,
                timerProgressBar: true,
                showConfirmButton: false,
            });
        </script>
    @endif

    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: '{{ session('error') }}',
                confirmButtonColor: '#f97316'
            });
        </script>
    @endif

    <script>
        $(function () {
            $('#orderTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('customer.orders.datatable') }}",
                order: [[4, 'desc']],
                columns: [
                    { data: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'order_number', name: 'order_number' },
                    { data: 'status', name: 'status' },
                    { data: 'grand_total', name: 'grand_total' },
                    { data: 'created_at', name: 'created_at' },
                    { data: 'action', orderable: false, searchable: false },
                ],
                language: {
                    processing:     "Sedang memproses...",
                    search:         "Cari:",
                    lengthMenu:     "Tampilkan _MENU_ data",
                    info:           "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                    infoEmpty:      "Menampilkan 0 sampai 0 dari 0 data",
                    infoFiltered:   "(disaring dari _MAX_ data keseluruhan)",
                    infoPostFix:    "",
                    loadingRecords: "Memuat...",
                    zeroRecords:    "Tidak ada data yang cocok",
                    emptyTable:     "Tidak ada data tersedia di tabel",
                    paginate: {
                        first:      "Pertama",
                        previous:   "Sebelumnya",
                        next:       "Berikutnya",
                        last:       "Terakhir"
                    },
                    aria: {
                        sortAscending:  ": aktifkan untuk mengurutkan kolom secara naik",
                        sortDescending: ": aktifkan untuk mengurutkan kolom secara turun"
                    },
                    buttons: {
                        copy: "Salin",
                        csv: "CSV",
                        excel: "Excel",
                        pdf: "PDF",
                        print: "Cetak",
                        colvis: "Tampilkan Kolom"
                    }
                }
            });
        });
    </script>
@endpush
