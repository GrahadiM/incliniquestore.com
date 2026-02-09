@extends('layouts.frontend')

@section('title', 'Customer Dashboard')

@section('content')
    <section class="bg-primary-light py-10 md:py-16">
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
                <aside class="bg-white rounded-2xl shadow-sm p-6">
                    <nav class="space-y-4">

                        <a href="{{ route('customer.dashboard') }}"
                            class="flex items-center gap-3 font-medium
                            {{ request()->routeIs('customer.dashboard')
                                ? 'text-primary-orange'
                                : 'text-gray-700 hover:text-primary-orange'
                            }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 text-gray-700 hover:text-primary-orange">
                            <i class="fas fa-box"></i> Pesanan Saya
                        </a>

                        <a href="#"
                            class="flex items-center gap-3 text-gray-700 hover:text-primary-orange">
                            <i class="fas fa-user"></i> Profil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-3 text-red-500 hover:text-red-600">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>

                    </nav>
                </aside>

                {{-- MAIN CONTENT --}}
                <main class="lg:col-span-3 space-y-6">

                    {{-- STATS --}}
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

                        <div class="bg-white rounded-2xl p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Total Pesanan</p>
                                    <p class="text-2xl font-bold text-gray-800">0</p>
                                </div>
                                <i class="fas fa-shopping-bag text-2xl text-primary-orange"></i>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Pesanan Aktif</p>
                                    <p class="text-2xl font-bold text-gray-800">0</p>
                                </div>
                                <i class="fas fa-truck text-2xl text-primary-orange"></i>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl p-6 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-gray-500">Point Loyalty</p>
                                    <p class="text-2xl font-bold text-gray-800">0</p>
                                </div>
                                <i class="fas fa-star text-2xl text-primary-orange"></i>
                            </div>
                        </div>

                    </div>

                    {{-- INFO --}}
                    <div class="bg-white rounded-2xl shadow-sm p-6">
                        <h2 class="text-lg font-semibold text-gray-800 mb-4">
                            Informasi Akun
                        </h2>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Nama</p>
                                <p class="font-medium text-gray-800">{{ $user->name }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Email</p>
                                <p class="font-medium text-gray-800">{{ $user->email }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Bergabung Sejak</p>
                                <p class="font-medium text-gray-800">
                                    {{ $user->created_at->format('d M Y') }}
                                </p>
                            </div>
                        </div>
                    </div>

                </main>
            </div>

        </div>
    </section>
@endsection
