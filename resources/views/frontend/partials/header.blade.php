<!-- Header & Navigation -->
<header class="bg-white shadow-sm sticky top-0 border-b border-primary-orange z-50">
    <div class="w-full lg:max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
        <div class="flex items-center cursor-pointer space-x-4" onclick="window.location.href='{{ route('frontend.index') }}';">
            <h1 class="text-2xl font-bold text-primary-orange">Inclinique<span class="text-primary-red"> Store</span></h1>
        </div>

        <!-- Desktop Navigation (hanya untuk layar besar) -->
        <nav class="hidden lg:block space-x-8">
            @foreach (config('menu.top_nav') as $menu)
                <a href="{{ route($menu['route']) }}" class="text-sm xl:text-base font-medium {{ $menu['route'] == request()->route()->getName() ? 'text-primary-orange border-b-2 border-primary-orange py-2' : 'text-gray-700 hover:text-primary-orange' }}">{{ strtoupper($menu['label']) }}</a>
            @endforeach
        </nav>

        <!-- Mobile & Tablet Header Icons (untuk layar di bawah lg) -->
        <div class="flex items-center space-x-4 lg:hidden">
            <button id="search-toggle-mobile" class="text-gray-700 hover:text-primary-orange">
                <i class="fas fa-search"></i>
            </button>
            <a href="{{ route('frontend.cart.index') }}" class="hidden text-gray-700 hover:text-primary-orange relative transition-colors" aria-label="Shopping Cart">
                <i class="fas fa-shopping-cart"></i>
                <span class="absolute -top-2 -right-2 bg-primary-red text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
            </a>
            <!-- Hamburger Menu Button -->
            <button id="menu-toggle" class="text-gray-700">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- Desktop Header Icons (hanya untuk layar besar) -->
        <div class="hidden lg:block items-center space-x-4">
            <button id="search-toggle-desktop" class="text-gray-700 hover:text-primary-orange">
                <i class="fas fa-search"></i>
            </button>
            <a href="{{ route('frontend.cart.index') }}" class="text-gray-700 hover:text-primary-orange relative transition-colors" aria-label="Shopping Cart">
                <i class="fas fa-shopping-cart"></i>
                <span class="absolute -top-2 -right-2 bg-primary-red text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
            </a>
            <a href="{{ route('login') }}" class="text-gray-700 hover:text-primary-orange transition-colors" aria-label="User Account">
                <i class="fas fa-user"></i>
            </a>
        </div>
    </div>
</header>

<!-- Search Popup -->
<div id="search-overlay" class="search-overlay fixed inset-0 bg-black bg-opacity-50 z-50"></div>
<div id="search-popup" class="search-popup fixed top-0 left-0 right-0 bg-primary-light z-50 p-6 shadow-lg">
    <div class="w-full lg:max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-xl font-bold text-gray-800">Cari Produk</h2>
            <button id="close-search" class="text-gray-700">
                <i class="fas fa-times text-xl"></i>
            </button>
        </div>

        <div class="relative mb-6">
            <input type="text" id="search-input" placeholder="Ketik nama produk yang dicari..."
                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-orange focus:ring-2 focus:ring-primary-orange focus:ring-opacity-20">
            <button class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-700 hover:text-primary-orange">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <div id="search-results" class="max-h-96 overflow-y-auto scrollbar-hide">
            <!-- Hasil pencarian akan muncul di sini -->
            <div id="search-empty" class="text-center py-8 text-gray-500">
                <i class="fas fa-search text-4xl mb-4 opacity-50"></i>
                <p>Ketik nama produk untuk memulai pencarian</p>
            </div>

            <div id="search-loading" class="hidden text-center py-8">
                <i class="fas fa-spinner fa-spin text-2xl text-primary-orange mb-4"></i>
                <p>Mencari produk...</p>
            </div>

            <div id="search-no-results" class="hidden text-center py-8 text-gray-500">
                <i class="fas fa-times-circle text-4xl mb-4 opacity-50"></i>
                <p>Produk tidak ditemukan</p>
                <p class="text-sm">Coba gunakan kata kunci yang berbeda</p>
            </div>

            <div id="search-results-container" class="hidden grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Template untuk hasil pencarian -->
                <template id="product-template">
                    @include('frontend.partials.search.product-card')
                </template>
            </div>
        </div>
    </div>
</div>

<!-- Sidebar Menu for Mobile & Tablet -->
<div id="sidebar-overlay" class="sidebar-overlay fixed inset-0 bg-black bg-opacity-50 z-50"></div>
<div id="sidebar" class="sidebar fixed top-0 left-0 h-full w-64 bg-white z-50 p-6">
    <div class="flex justify-between items-center mb-8">
        <h2 class="text-xl font-bold text-primary-orange">Inclinique<span class="text-primary-red"> Store</span>
        </h2>
        <button id="close-sidebar" class="text-gray-700">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <nav class="space-y-6">
        <a href="index.html"
            class="block text-gray-700 hover:text-primary-orange font-medium py-2 border-b border-gray-100">
            <i class="fas fa-home mr-3"></i>HOME
        </a>
        <a href="product.html"
            class="block text-gray-700 hover:text-primary-orange font-medium py-2 border-b border-gray-100">
            <i class="fas fa-shopping-bag mr-3"></i>SHOP ALL
        </a>
        <a href="news.html"
            class="block text-gray-700 hover:text-primary-orange font-medium py-2 border-b border-gray-100">
            <i class="fas fa-blog mr-3"></i>BEAUTY INSIDER
        </a>
        <a href="about.html"
            class="block text-gray-700 hover:text-primary-orange font-medium py-2 border-b border-gray-100">
            <i class="fas fa-info-circle mr-3"></i>ABOUT US
        </a>
        <a href="career.html"
            class="block text-gray-700 hover:text-primary-orange font-medium py-2 border-b border-gray-100">
            <i class="fas fa-envelope mr-3"></i>CAREER
        </a>
        <a href="#"
            class="block text-gray-700 hover:text-primary-orange font-medium py-2 border-b border-gray-100">
            <i class="fas fa-search mr-3"></i>Pencarian
        </a>
        <a href="#"
            class="block text-gray-700 hover:text-primary-orange font-medium py-2 border-b border-gray-100">
            <i class="fas fa-user mr-3"></i>Akun Saya
        </a>
    </nav>

    <div class="mt-8 pt-6 border-t border-gray-200">
        <h3 class="font-semibold text-gray-700 mb-4">Kategori Produk</h3>
        <div class="space-y-3">
            <a href="#" class="block text-gray-600 hover:text-primary-orange">Pembersih Wajah</a>
            <a href="#" class="block text-gray-600 hover:text-primary-orange">Pelembap</a>
            <a href="#" class="block text-gray-600 hover:text-primary-orange">Serum</a>
            <a href="#" class="block text-gray-600 hover:text-primary-orange">Tabir Surya</a>
            <a href="#" class="block text-gray-600 hover:text-primary-orange">Perawatan Khusus</a>
        </div>
    </div>
</div>
