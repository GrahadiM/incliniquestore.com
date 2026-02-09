@extends('layouts.frontend')

@push('meta')
    @php
        $title = $data['category']->name;
        $description = $data['category']->name;
        $keywords = $data['category']->name;
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
                <a href="{{ route('frontend.shop.index') }}" class="hover:text-primary-orange">Shop</a>
                <span class="mx-2">/</span>
                <span class="text-gray-700 font-medium">{{ $data['category']->name }}</span>
            </nav>

            <div class="flex flex-col lg:flex-row gap-4">
                {{-- Sidebar Categories (Sticky on lg+) --}}
                <div class="lg:w-1/4 xl:w-1/5">
                    <div class="hidden lg:block sticky top-6">
                        <div class="bg-white rounded-tl-[24px] rounded-br-[24px] shadow-sm p-4 border border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 pb-3 border-b border-gray-200">
                                Kategori
                            </h3>
                            <ul class="space-y-2">
                                <li>
                                    <a href="{{ route('frontend.shop.index') }}">
                                        <span class="flex items-center justify-between py-2 px-2 rounded-lg text-sm hover:bg-orange-50 hover:text-primary-orange transition-all duration-200
                                                {{ request()->is('shop') ? 'bg-orange-50 text-primary-orange font-medium border-l-4 border-primary-orange' : 'text-gray-700' }}">
                                            <span>Semua Produk</span>
                                            <span class="text-xs font-semibold bg-gray-200 px-2 py-1 rounded-sm text-gray-600">
                                                {{ $data['all_products_count'] }}
                                            </span>
                                        </span>
                                    </a>
                                </li>
                                @foreach ($data['categories'] as $category)
                                    <li>
                                        <a href="{{ route('frontend.shop.category.index', ['slug' => $category->slug]) }}"
                                        class="flex items-center justify-between py-2 px-2 rounded-lg text-sm hover:bg-orange-50 hover:text-primary-orange transition-all duration-200
                                                {{ request()->route()->getName() == 'frontend.shop.category.index' && request()->route('slug') == $category->slug ? 'bg-orange-50 text-primary-orange font-medium border-l-4 border-primary-orange' : 'text-gray-700' }}">
                                            <span>{{ $category->name }}</span>
                                            <span class="text-xs font-semibold bg-gray-200 px-2 py-1 rounded-sm text-gray-600">
                                                {{-- Optional: Count produk per kategori --}}
                                                {{ $category->productsCount() }}
                                            </span>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Mobile Category Dropdown --}}
                    <div class="lg:hidden mb-6">
                        <select onchange="window.location.href=this.value" class="w-full px-4 py-3 rounded-tl-[12px] rounded-br-[12px] lg:rounded-tl-[24px] lg:rounded-br-[24px] border border-gray-300 bg-white text-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-orange focus:border-transparent">
                            <option value="{{ route('frontend.shop.category.index', ['slug' => 'all']) }}" {{ request()->route()->getName() == 'frontend.shop.index' ? 'selected' : '' }}>Semua Kategori</option>
                            @foreach ($data['categories'] as $category)
                                <option value="{{ route('frontend.shop.category.index', ['slug' => $category->slug]) }}" {{ request()->route()->getName() == 'frontend.shop.category.index' && request()->route('slug') == $category->slug ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Products Grid --}}
                <div class="lg:w-3/4 xl:w-4/5">
                    @if($data['products']->count())
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6">
                            @foreach ($data['products'] as $product)
                                @include('frontend.partials.product-card', ['product' => $product])
                            @endforeach
                        </div>

                        {{-- Pagination --}}
                        @if($data['products']->hasPages())
                            <div class="mt-12 pt-8 border-t border-gray-200">
                                {{ $data['products']->links('pagination::tailwind') }}
                            </div>
                        @endif
                    @else
                        <div class="text-center md:py-16">
                            <div class="inline-block p-6 bg-white rounded-lg shadow-sm border border-gray-200">
                                <i class="fas fa-box-open text-4xl text-gray-400 mb-4"></i>
                                <h3 class="text-lg font-medium text-gray-700 mb-2">Produk Tidak Ditemukan</h3>
                                <p class="text-gray-500 mb-4">Tidak ada produk yang tersedia untuk kategori ini.</p>
                                <a href="{{ route('frontend.shop.index') }}"
                                class="inline-block bg-primary-orange text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition-colors duration-200">
                                    Lihat Semua Produk
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </section>
@endsection
