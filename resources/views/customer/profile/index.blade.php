@extends('layouts.frontend')

@push('meta')
    @php
        $title = 'Profile Saya';
        $description = 'Kelola informasi akun dan alamat';
        $keywords = 'Profile, Alamat';
    @endphp
    @include('frontend.partials.meta-home')
@endpush

@section('content')
    <section class="bg-gray-50 py-10 md:py-16">
        <div class="max-w-7xl mx-auto px-4">

            {{-- HEADER --}}
            <div class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    Profile Saya
                </h1>
                <p class="text-gray-500 mt-1">
                    Kelola data akun dan alamat pengiriman
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                {{-- SIDEBAR --}}
                @include('customer.partials.sidebar')

                {{-- MAIN --}}
                <main class="lg:col-span-3 space-y-6">

                    {{-- PROFILE CARD --}}
                    <div class="bg-white rounded-2xl shadow p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">
                                Informasi Akun
                            </h2>
                            <a href="{{ route('customer.profile.edit') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold bg-primary-orange text-white rounded-lg hover:bg-orange-600">
                                <i class="fas fa-pencil"></i> Edit Profile
                            </a>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div class="font-semibold">
                                <p class="text-gray-500">Nama Lengkap</p>
                                <p class="text-gray-800">{{ $user->name }}</p>
                            </div>
                            <div class="font-semibold">
                                <p class="text-gray-500">Email Address</p>
                                <p class="text-gray-800">{{ $user->email }}</p>
                            </div>
                            <div class="font-semibold">
                                <p class="text-gray-500">No. WhatsApp</p>
                                <p class="text-gray-800">{{ $user->phone ?? '-' }}</p>
                            </div>
                            <div class="font-semibold">
                                <p class="text-gray-500">Level Member</p>
                                <p class="text-gray-800">{{ $user->memberLevel->name ?? '-' }}</p>
                            </div>
                            <div class="font-semibold">
                                <p class="text-gray-500">Daftar Akun</p>
                                <p class="text-gray-800">
                                    {{ $user->created_at->translatedFormat('l, d F Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- ADDRESS LIST --}}
                    <div class="bg-white rounded-2xl shadow p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-800">
                                Alamat Pengiriman
                            </h2>
                            <a href="{{ route('customer.address.create') }}" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-semibold bg-primary-orange text-white rounded-lg hover:bg-orange-600">
                                <i class="fas fa-plus"></i> Tambah Alamat
                            </a>
                        </div>

                        @if ($addresses->isEmpty())
                            <div class="bg-white rounded-xl border p-10 text-center">
                                <p class="text-gray-600 font-medium">Belum ada alamat tersimpan</p>
                                <p class="text-sm text-gray-400 mt-1">
                                    Tambahkan alamat untuk mempercepat proses checkout
                                </p>
                            </div>
                        @else
                            <div class="space-y-4">
                                @foreach ($addresses as $address)
                                    <div class="bg-white border rounded-xl p-5 flex flex-col md:flex-row md:items-start md:justify-between gap-4 hover:border-orange-300 transition">

                                        {{-- INFO --}}
                                        <div class="flex-1">
                                            <div class="flex items-center gap-2">
                                                <p class="font-semibold text-gray-800">{{ $address->label }}</p>
                                                @if ($address->is_default)
                                                    <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full font-medium">
                                                        Alamat Utama
                                                    </span>
                                                @endif
                                            </div>

                                            <p class="text-sm text-gray-700 mt-1 font-medium">
                                                {{ $address->recipient_name }}
                                                <span class="text-gray-500 font-normal">{{ $address->phone }}</span>
                                            </p>

                                            <p class="text-sm text-gray-500 mt-1">{{ $address->address }}</p>

                                            {{-- GOOGLE MAPS --}}
                                            {{-- @if ($address->latitude && $address->longitude)
                                                <div id="map-{{ $address->id }}" class="h-64 rounded-xl mt-4 border"></div>
                                            @endif --}}
                                        </div>

                                        {{-- ACTION --}}
                                        <div class="flex md:flex-col justify-end gap-1 text-xs shrink-0">
                                            <a href="{{ route('customer.address.edit', $address) }}" class="inline-flex items-center gap-2 bg-primary-orange text-white px-3 py-2 rounded-lg hover:bg-orange-600 font-medium">
                                                <i class="fas fa-pencil"></i> Edit
                                            </a>

                                            <form method="POST" action="{{ route('customer.address.destroy', $address) }}" onsubmit="return confirm('Hapus alamat ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="inline-flex items-center gap-2 bg-red-500 text-white px-3 py-2 rounded-lg hover:bg-red-600 font-medium">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </main>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @if ($addresses->whereNotNull('latitude')->count() > 0)
    <script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}"></script>
    <script>
        @foreach ($addresses as $address)
            @if ($address->latitude && $address->longitude)
                const map{{ $address->id }} = new google.maps.Map(document.getElementById("map-{{ $address->id }}"), {
                    zoom: 15,
                    center: { lat: {{ $address->latitude }}, lng: {{ $address->longitude }} }
                });

                const marker{{ $address->id }} = new google.maps.Marker({
                    position: { lat: {{ $address->latitude }}, lng: {{ $address->longitude }} },
                    map: map{{ $address->id }},
                });
            @endif
        @endforeach
    </script>
    @endif

    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Sukses',
                text: @json(session('success')),
                confirmButtonColor: '#f97316'
            });
        </script>
    @endif

    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                html: @json(implode('<br>', $errors->all())),
                confirmButtonColor: '#f97316'
            });
        </script>
    @endif
@endpush
