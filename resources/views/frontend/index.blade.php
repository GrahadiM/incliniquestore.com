<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inclinique Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-gradient {
            background: linear-gradient(135deg, #FEF3E2 0%, #FA812F 100%);
        }

        .product-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .skin-type-btn.active {
            background-color: #FA812F;
            color: white;
        }

        /* Sidebar Styles */
        .sidebar {
            transform: translateX(-100%);
            transition: transform 0.3s ease-in-out;
        }

        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        .sidebar-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        /* Search Popup Styles */
        .search-popup {
            transform: translateY(-100%);
            opacity: 0;
            transition: transform 0.3s ease-in-out, opacity 0.3s ease-in-out;
        }

        .search-popup.open {
            transform: translateY(0);
            opacity: 1;
        }

        .search-overlay {
            opacity: 0;
            visibility: hidden;
            transition: opacity 0.3s ease-in-out, visibility 0.3s ease-in-out;
        }

        .search-overlay.open {
            opacity: 1;
            visibility: visible;
        }

        /* Bottom Navigation */
        .bottom-nav {
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }

        /* Custom colors */
        .bg-primary-light {
            background-color: #FFECC0;
        }

        .bg-primary-yellow {
            background-color: #FAB12F;
        }

        .bg-primary-orange {
            background-color: #FA812F;
        }

        .bg-primary-red {
            background-color: #DD0303;
        }

        .bg-primary-green {
            background-color: #28A745;
        }

        .bg-primary-blue {
            background-color: #007BFF;
        }

        .bg-primary-purple {
            background-color: #6F42C1;
        }

        .bg-primary-pink {
            background-color: #E83E8C;
        }

        .bg-primary-indigo {
            background-color: #6610F2;
        }

        .bg-primary-teal {
            background-color: #20C997;
        }

        .bg-primary-cyan {
            background-color: #17A2B8;
        }

        .text-primary-yellow {
            color: #FAB12F;
        }

        .text-primary-orange {
            color: #FA812F;
        }

        .text-primary-red {
            color: #DD0303;
        }

        .border-primary-orange {
            border-color: #FA812F;
        }

        .hover\:bg-primary-orange:hover {
            background-color: #FA812F;
        }

        .hover\:text-primary-orange:hover {
            color: #FA812F;
        }

        /* Custom button styles */
        .btn-block {
            display: block;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body class="font-sans">
    <!-- Header & Navigation -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="w-full lg:max-w-7xl mx-auto px-4 py-3 flex justify-between items-center">
            <div class="flex items-center">
                <h1 class="text-2xl font-bold text-primary-orange">Inclinique<span class="text-primary-red">
                        Store</span></h1>
            </div>

            <!-- Desktop Navigation (hanya untuk layar besar) -->
            <nav class="hidden lg:flex space-x-8">
                <a href="index.html" class="text-primary-orange font-medium border-b-2 border-primary-orange">HOME</a>
                <a href="product.html" class="text-gray-700 hover:text-primary-orange font-medium">SHOP ALL</a>
                <a href="news.html" class="text-gray-700 hover:text-primary-orange font-medium">BEAUTY INSIDER</a>
                <a href="about.html" class="text-gray-700 hover:text-primary-orange font-medium">ABOUT US</a>
                <a href="career.html" class="text-gray-700 hover:text-primary-orange font-medium">CAREER</a>
            </nav>

            <!-- Mobile & Tablet Header Icons (untuk layar di bawah lg) -->
            <div class="flex items-center space-x-4 lg:hidden">
                <button id="search-toggle-mobile" class="text-gray-700 hover:text-primary-orange">
                    <i class="fas fa-search"></i>
                </button>
                <a href="cart.html" class="text-gray-700 hover:text-primary-orange relative transition-colors"
                    aria-label="Shopping Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span
                        class="absolute -top-2 -right-2 bg-primary-red text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                </a>
                <!-- Hamburger Menu Button -->
                <button id="menu-toggle" class="text-gray-700">
                    <i class="fas fa-bars text-xl"></i>
                </button>
            </div>

            <!-- Desktop Header Icons (hanya untuk layar besar) -->
            <div class="hidden lg:flex items-center space-x-4">
                <button id="search-toggle-desktop" class="text-gray-700 hover:text-primary-orange">
                    <i class="fas fa-search"></i>
                </button>
                <a href="cart.html" class="text-gray-700 hover:text-primary-orange relative transition-colors"
                    aria-label="Shopping Cart">
                    <i class="fas fa-shopping-cart"></i>
                    <span
                        class="absolute -top-2 -right-2 bg-primary-red text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">3</span>
                </a>
                <a href="account.html" class="text-gray-700 hover:text-primary-orange transition-colors"
                    aria-label="User Account">
                    <i class="fas fa-user"></i>
                </a>
            </div>
        </div>
    </header>

    <!-- Search Popup -->
    <div id="search-overlay" class="search-overlay fixed inset-0 bg-black bg-opacity-50 z-50"></div>
    <div id="search-popup" class="search-popup fixed top-0 left-0 right-0 bg-white z-50 p-6 shadow-lg">
        <div class="w-full lg:max-w-7xl mx-auto">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold text-primary-orange">Cari Produk</h2>
                <button id="close-search" class="text-gray-700">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>

            <div class="relative mb-6">
                <input type="text" id="search-input" placeholder="Ketik nama produk yang dicari..."
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-primary-orange focus:ring-2 focus:ring-primary-orange focus:ring-opacity-20">
                <button
                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary-orange">
                    <i class="fas fa-search"></i>
                </button>
            </div>

            <div id="search-results" class="max-h-96 overflow-y-auto">
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
                        <div class="bg-white border border-gray-200 rounded-lg p-4 hover:shadow-md transition-shadow">
                            <div class="flex items-start space-x-4">
                                <img class="w-16 h-16 object-cover rounded-lg" src="" alt="">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-800 mb-1"></h3>
                                    <p class="text-sm text-gray-600 mb-2"></p>
                                    <div class="space-y-2">
                                        <span class="font-bold text-primary-orange text-lg block"></span>
                                        <button
                                            class="btn-block bg-primary-orange text-white py-2 px-4 rounded-lg font-medium hover:bg-primary-red transition duration-300 flex items-center justify-center space-x-2">
                                            <!-- <i class="fas fa-shopping-cart"></i> -->
                                            <span>+ Keranjang</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
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

    <!-- Hero Section -->
    <section class="hero-gradient py-16 lg:py-24">
        <div class="w-full lg:max-w-7xl mx-auto px-4 flex flex-col lg:flex-row items-center">
            <div class="lg:w-1/2 mb-10 lg:mb-0">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-4">Kulit Sehat, <span
                        class="text-primary-orange">Percaya Diri</span> Meningkat</h1>
                <p class="text-lg text-gray-600 mb-8">Temukan rangkaian skincare terbaik yang diformulasikan khusus
                    untuk jenis kulit Anda. Hasil terlihat dalam 2 minggu!</p>
                <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                    <button onclick="window.location.href='product.html';"
                        class="border border-primary-orange bg-primary-orange text-white px-6 py-3 rounded-lg font-medium hover:bg-transparent hover:text-primary-orange transition duration-300">Belanja
                        Sekarang</button>
                    <button onclick="window.location.href='order-tracking.html';"
                        class="border border-primary-orange text-primary-orange px-6 py-3 rounded-lg font-medium hover:bg-primary-orange hover:text-white transition duration-300">Lacak
                        Pesanan</button>
                </div>
            </div>
            <div class="lg:w-1/2 flex justify-center">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1556228578-8c89e6adf883?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80"
                        alt="Skincare Products" class="rounded-lg shadow-xl w-full max-w-md">
                    <div class="absolute -bottom-4 -left-4 bg-white p-4 rounded-lg shadow-lg hidden lg:block">
                        <p class="text-sm text-gray-600">Lebih dari <span
                                class="font-bold text-primary-orange">10.000+</span> pelanggan puas</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skin Type Recommendation -->
    <section class="py-16 bg-white">
        <div class="w-full lg:max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Tidak Tahu Produk yang Cocok?</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Jelajahi rekomendasi produk berdasarkan jenis kulit Anda
                    untuk hasil terbaik</p>
            </div>

            <div class="flex flex-wrap justify-center gap-4 mb-12">
                <button
                    class="skin-type-btn active px-4 py-2 lg:px-6 lg:py-3 rounded-full border border-gray-300 hover:border-primary-orange hover:bg-primary-orange hover:text-white transition duration-300 text-sm lg:text-base font-semibold"
                    data-type="normal">KULIT NORMAL</button>
                <button
                    class="skin-type-btn px-4 py-2 lg:px-6 lg:py-3 rounded-full border border-gray-300 hover:border-primary-orange hover:bg-primary-orange hover:text-white transition duration-300 text-sm lg:text-base font-semibold"
                    data-type="oily">KULIT BERMINYAK</button>
                <button
                    class="skin-type-btn px-4 py-2 lg:px-6 lg:py-3 rounded-full border border-gray-300 hover:border-primary-orange hover:bg-primary-orange hover:text-white transition duration-300 text-sm lg:text-base font-semibold"
                    data-type="dry">KULIT KERING</button>
                <button
                    class="skin-type-btn px-4 py-2 lg:px-6 lg:py-3 rounded-full border border-gray-300 hover:border-primary-orange hover:bg-primary-orange hover:text-white transition duration-300 text-sm lg:text-base font-semibold"
                    data-type="sensitive">KULIT SENSITIF</button>
                <button
                    class="skin-type-btn px-4 py-2 lg:px-6 lg:py-3 rounded-full border border-gray-300 hover:border-primary-orange hover:bg-primary-orange hover:text-white transition duration-300 text-sm lg:text-base font-semibold"
                    data-type="combination">KOMBINASI</button>
            </div>

            <!-- Content for Normal Skin (Default) -->
            <div id="skin-normal" class="skin-content grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-primary-light p-6 rounded-tl-[32px] rounded-br-[32px] product-card">
                    <div class="bg-orange-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-pump-soap text-primary-orange text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Gentle Cleanser</h3>
                    <p class="text-gray-600 mb-4">Pembersih lembut yang membersihkan tanpa mengikis minyak alami kulit.
                    </p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>

                <div class="bg-primary-light p-6 rounded-bl-[32px] rounded-tr-[32px] product-card">
                    <div class="bg-yellow-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-tint text-primary-yellow text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Light Moisturizer</h3>
                    <p class="text-gray-600 mb-4">Pelembap ringan dengan tekstur lotion untuk menjaga keseimbangan
                        kulit.</p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>

                <div class="bg-primary-light p-6 rounded-tl-[32px] rounded-br-[32px] product-card">
                    <div class="bg-red-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-shield-alt text-primary-red text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Daily Sunscreen</h3>
                    <p class="text-gray-600 mb-4">Tabir surya SPF 30+ dengan tekstur ringan untuk perlindungan
                        sehari-hari.</p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>
            </div>

            <!-- Content for Oily Skin -->
            <div id="skin-oily" class="skin-content hidden grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-primary-light p-6 rounded-tl-[32px] rounded-br-[32px] product-card">
                    <div class="bg-green-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-wind text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Oil-Control Cleanser</h3>
                    <p class="text-gray-600 mb-4">Pembersih dengan formula oil-free yang mengurangi produksi minyak
                        berlebih.</p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>

                <div class="bg-primary-light p-6 rounded-bl-[32px] rounded-tr-[32px] product-card">
                    <div class="bg-blue-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-leaf text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Mattifying Moisturizer</h3>
                    <p class="text-gray-600 mb-4">Pelembap gel dengan teknologi matte finish untuk kulit bebas kilap.
                    </p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>

                <div class="bg-primary-light p-6 rounded-tl-[32px] rounded-br-[32px] product-card">
                    <div class="bg-purple-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-magic text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Pore Refining Serum</h3>
                    <p class="text-gray-600 mb-4">Serum dengan niacinamide untuk meminimalkan pori-pori dan mengontrol
                        minyak.</p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>
            </div>

            <!-- Content for Dry Skin -->
            <div id="skin-dry" class="skin-content hidden grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-primary-light p-6 rounded-tl-[32px] rounded-br-[32px] product-card">
                    <div class="bg-yellow-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-cloud-rain text-yellow-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Hydrating Cleanser</h3>
                    <p class="text-gray-600 mb-4">Pembersih krim dengan hyaluronic acid yang tidak membuat kulit
                        kering.
                    </p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>

                <div class="bg-primary-light p-6 rounded-bl-[32px] rounded-tr-[32px] product-card">
                    <div class="bg-pink-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-tint text-pink-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Rich Cream Moisturizer</h3>
                    <p class="text-gray-600 mb-4">Pelembap intensif dengan ceramides untuk kulit sangat kering.</p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>

                <div class="bg-primary-light p-6 rounded-tl-[32px] rounded-br-[32px] product-card">
                    <div class="bg-indigo-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-water text-indigo-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Hyaluronic Acid Serum</h3>
                    <p class="text-gray-600 mb-4">Serum dengan 3 jenis hyaluronic acid untuk hidrasi maksimal.</p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>
            </div>

            <!-- Content for Sensitive Skin -->
            <div id="skin-sensitive" class="skin-content hidden grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-primary-light p-6 rounded-tl-[32px] rounded-br-[32px] product-card">
                    <div class="bg-green-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-heart text-green-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Calming Cleanser</h3>
                    <p class="text-gray-600 mb-4">Pembersih hypoallergenic dengan chamomile untuk kulit sensitif.</p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>

                <div class="bg-primary-light p-6 rounded-bl-[32px] rounded-tr-[32px] product-card">
                    <div class="bg-blue-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-shield-virus text-blue-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Barrier Repair Cream</h3>
                    <p class="text-gray-600 mb-4">Pelembap dengan centella asiatica untuk memperbaiki skin barrier.</p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>

                <div class="bg-primary-light p-6 rounded-tl-[32px] rounded-br-[32px] product-card">
                    <div class="bg-purple-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-spa text-purple-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Soothing Toner</h3>
                    <p class="text-gray-600 mb-4">Toner bebas alkohol dengan oat extract untuk menenangkan kulit.</p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>
            </div>

            <!-- Content for Combination Skin -->
            <div id="skin-combination" class="skin-content hidden grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-primary-light p-6 rounded-tl-[32px] rounded-br-[32px] product-card">
                    <div class="bg-orange-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-balance-scale text-orange-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Balancing Cleanser</h3>
                    <p class="text-gray-600 mb-4">Pembersih yang membersihkan area berminyak tanpa mengeringkan area
                        kering.</p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>

                <div class="bg-primary-light p-6 rounded-bl-[32px] rounded-tr-[32px] product-card">
                    <div class="bg-teal-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-adjust text-teal-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Dual Moisturizer</h3>
                    <p class="text-gray-600 mb-4">Pelembap dengan tekstur berbeda untuk area T-zone dan pipi.</p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>

                <div class="bg-primary-light p-6 rounded-tl-[32px] rounded-br-[32px] product-card">
                    <div class="bg-cyan-100 w-16 h-16 rounded-lg flex items-center justify-center mb-4">
                        <i class="fas fa-sync-alt text-cyan-600 text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Zone Control Serum</h3>
                    <p class="text-gray-600 mb-4">Serum yang mengontrol minyak di T-zone sambil melembapkan area
                        kering.
                    </p>
                    <a href="#" class="text-primary-orange font-medium flex items-center">Lihat Produk <i
                            class="fas fa-arrow-right ml-2"></i></a>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 bg-primary-light">
        <div class="w-full lg:max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">BEST SELLER</h2>
                <a href="#" class="text-primary-orange font-medium flex items-center hidden lg:flex">
                    Lihat Semua
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-5 gap-8">
                @foreach ($products as $product)
                    <div class="bg-white rounded-lg overflow-hidden shadow-md product-card">
                        <div class="relative">
                            <img
                                src="{{ config('app.asset_url', 'https://admin.incliniquestore.com') }}/storage/{{ $product?->thumbnail }}"
                                alt="{{ $product?->name }}"
                                class="w-full aspect-square object-cover"
                            >

                            @if ($product?->is_featured)
                                <span
                                    class="absolute top-0 left-0 bg-primary-orange text-white text-xs font-semibold px-2 py-1 rounded">
                                    BESTSELLER
                                </span>
                            @endif

                            @if ($product?->discount > 0)
                                <span
                                    class="absolute top-0 right-0 bg-primary-red text-white text-xs font-semibold px-2 py-1 rounded">
                                    {{ $product?->discount }}%
                                </span>
                            @endif
                        </div>

                        <div class="p-4">
                            <h3 class="font-semibold text-sm text-gray-800 hover:cursor-pointer mb-1">
                                {{ $product?->name }}
                            </h3>

                            <div class="space-y-0 mb-3">
                                <div class="flex items-center space-x-2">
                                    <span class="font-bold text-primary-red text-lg">
                                        Rp {{ number_format($product?->price_final, 0, ',', '.') }}
                                    </span>

                                    @if ($product?->discount > 0)
                                        <span class="text-gray-500 text-sm line-through">
                                            Rp {{ number_format($product?->price, 0, ',', '.') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <button
                                class="btn-block bg-primary-orange text-white py-2 rounded-lg hover:bg-opacity-90 transition duration-300 flex items-center justify-center space-x-2 mb-2">
                                <i class="fas fa-shopping-cart"></i>
                                <span>Keranjang</span>
                            </button>

                            <button
                                class="btn-block border border-primary-orange text-primary-orange py-2 rounded-lg hover:bg-primary-orange hover:text-white transition duration-300 flex items-center justify-center space-x-2">
                                <i class="far fa-heart"></i>
                                <span>Wishlist</span>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Mobile & Tablet View All Button -->
            <div class="mt-8 text-center lg:hidden">
                <a href="#"
                    class="inline-block bg-primary-orange text-white px-6 py-3 rounded-lg font-medium hover:bg-primary-red transition duration-300">Lihat
                    Semua Produk</a>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="py-16 bg-white">
        <div class="w-full lg:max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Apa Kata Pelanggan Kami</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Lihat pengalaman nyata dari ribuan pelanggan yang telah
                    merasakan manfaat produk Inclinique Store</p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-primary-light p-6 rounded-lg">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
                            alt="Customer" class="w-12 h-12 rounded-full object-cover">
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-800">Sarah Wijaya</h4>
                            <div class="flex text-yellow-400 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Kulit saya yang sensitif akhirnya menemukan produk yang cocok. Gentle
                        Cleanser tidak membuat kulit saya iritasi dan benar-benar membersihkan dengan lembut."</p>
                </div>

                <div class="bg-primary-light p-6 rounded-lg">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
                            alt="Customer" class="w-12 h-12 rounded-full object-cover">
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-800">Budi Santoso</h4>
                            <div class="flex text-yellow-400 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star-half-alt"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Sebagai pria dengan kulit berminyak, saya kesulitan menemukan produk yang
                        tepat. Setelah menggunakan rangkaian untuk kulit berminyak, wajah saya terasa lebih segar dan
                        tidak mengilap."</p>
                </div>

                <div class="bg-primary-light p-6 rounded-lg">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
                            alt="Customer" class="w-12 h-12 rounded-full object-cover">
                        <div class="ml-4">
                            <h4 class="font-semibold text-gray-800">Dewi Lestari</h4>
                            <div class="flex text-yellow-400 text-sm">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-600">"Hydrating Serum benar-benar mengubah kulit kering saya. Dalam 2 minggu,
                        kulit terasa lebih lembap dan kenyal. Sekarang tidak perlu lagi memakai pelembap tambahan."</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 bg-primary-orange text-white">
        <div class="w-full lg:max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Dapatkan Tips Perawatan Kulit Eksklusif</h2>
            <p class="max-w-2xl mx-auto mb-8">Berlangganan newsletter kami dan dapatkan tips perawatan kulit, promo
                spesial, dan informasi produk terbaru langsung di inbox Anda.</p>

            <div class="max-w-md mx-auto flex flex-col sm:flex-row">
                <input type="email" placeholder="Alamat email Anda"
                    class="flex-grow px-4 py-3 rounded-t-lg sm:rounded-l-lg sm:rounded-t-none text-gray-800 focus:outline-none">
                <button
                    class="bg-primary-red px-6 py-3 rounded-b-lg sm:rounded-r-lg sm:rounded-b-none font-medium hover:bg-red-800 transition duration-300">Berlangganan</button>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-12 lg:pb-12 pb-[120px]">
        <div class="w-full lg:max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                <div>
                    <h3 class="text-xl font-bold mb-4">Inclinique<span class="text-primary-red"> Store</span></h3>
                    <p class="text-gray-400 mb-4">Rangkaian skincare terbaik dengan formula yang aman dan efektif untuk
                        semua jenis kulit.</p>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Produk</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Pembersih</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Pelembap</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Serum</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Tabir Surya</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Perawatan Khusus</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Bantuan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white">Kontak Kami</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Pengiriman</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Pengembalian</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white">Kebijakan Privasi</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-semibold mb-4">Kontak</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li class="flex items-center">
                            <i class="fas fa-map-marker-alt mr-3"></i>
                            <span>Jl. Skincare No. 123, Jakarta</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-phone mr-3"></i>
                            <span>+62 857 6711 3554</span>
                        </li>
                        <li class="flex items-center">
                            <i class="fas fa-envelope mr-3"></i>
                            <span>info@incliniquestore.com</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy;
                    <script>
                        document.write(new Date().getFullYear())
                    </script> Inclinique Store. All rights reserved.
                </p>
            </div>
        </div>
    </footer>

    <!-- Bottom Navigation for Mobile & Tablet -->
    <nav
        class="bottom-nav fixed bottom-0 left-0 right-0 bg-white py-3 px-6 flex justify-between items-center lg:hidden z-40">
        <a href="#"
            class="flex flex-col items-center text-gray-700 hover:text-primary-orange transition-colors duration-300 w-full">
            <i class="fas fa-home text-2xl mb-1"></i>
            <span class="text-xs font-medium">Beranda</span>
        </a>
        <a href="#"
            class="flex flex-col items-center text-gray-700 hover:text-primary-orange transition-colors duration-300 w-full">
            <i class="fas fa-shopping-cart text-2xl mb-1"></i>
            <span class="text-xs font-medium">Pesanan</span>
        </a>
        <a href="#"
            class="flex flex-col items-center text-gray-700 hover:text-primary-orange transition-colors duration-300 w-full">
            <i class="fas fa-heart text-2xl mb-1"></i>
            <span class="text-xs font-medium">Favorit</span>
        </a>
        <a href="#"
            class="flex flex-col items-center text-gray-700 hover:text-primary-orange transition-colors duration-300 w-full">
            <i class="fas fa-user text-2xl mb-1"></i>
            <span class="text-xs font-medium">Masuk</span>
        </a>
    </nav>

    <script>
        // Data produk untuk pencarian
        const products = [{
                id: 1,
                name: "Hydrating Serum",
                description: "Serum dengan Hyaluronic Acid untuk kulit lembap maksimal",
                price: "Rp 189.000",
                image: "https://images.unsplash.com/photo-1556228578-9f6ac5e4d0d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
                category: "Serum"
            },
            {
                id: 2,
                name: "Vitamin C Cream",
                description: "Krim pagi dengan Vitamin C untuk kulit cerah dan terlindungi",
                price: "Rp 225.000",
                image: "https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
                category: "Pelembap"
            },
            {
                id: 3,
                name: "Gentle Cleanser",
                description: "Pembersih wajah lembut untuk kulit sensitif",
                price: "Rp 145.000",
                image: "https://images.unsplash.com/photo-1570194065650-4222e69b28d9?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
                category: "Pembersih"
            },
            {
                id: 4,
                name: "Night Repair",
                description: "Krim malam dengan Retinol untuk peremajaan kulit",
                price: "Rp 275.000",
                image: "https://images.unsplash.com/photo-1556228453-efd6c1ff04f6?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
                category: "Pelembap"
            },
            {
                id: 5,
                name: "Oil-Control Cleanser",
                description: "Pembersih dengan formula oil-free yang mengurangi produksi minyak berlebih",
                price: "Rp 165.000",
                image: "https://images.unsplash.com/photo-1556228578-9f6ac5e4d0d8?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
                category: "Pembersih"
            },
            {
                id: 6,
                name: "Hyaluronic Acid Serum",
                description: "Serum dengan 3 jenis hyaluronic acid untuk hidrasi maksimal",
                price: "Rp 195.000",
                image: "https://images.unsplash.com/photo-1596462502278-27bfdc403348?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=500&q=80",
                category: "Serum"
            }
        ];

        // JavaScript untuk interaktivitas
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality
            const searchToggleMobile = document.getElementById('search-toggle-mobile');
            const searchToggleDesktop = document.getElementById('search-toggle-desktop');
            const closeSearch = document.getElementById('close-search');
            const searchPopup = document.getElementById('search-popup');
            const searchOverlay = document.getElementById('search-overlay');
            const searchInput = document.getElementById('search-input');
            const searchResults = document.getElementById('search-results');
            const searchEmpty = document.getElementById('search-empty');
            const searchLoading = document.getElementById('search-loading');
            const searchNoResults = document.getElementById('search-no-results');
            const searchResultsContainer = document.getElementById('search-results-container');
            const productTemplate = document.getElementById('product-template');

            function openSearch() {
                searchPopup.classList.add('open');
                searchOverlay.classList.add('open');
                document.body.style.overflow = 'hidden';
                // Focus pada input search
                setTimeout(() => {
                    searchInput.focus();
                }, 300);
            }

            function closeSearchFunc() {
                searchPopup.classList.remove('open');
                searchOverlay.classList.remove('open');
                document.body.style.overflow = 'auto';
                // Reset pencarian
                searchInput.value = '';
                showEmptyState();
            }

            // Event listeners untuk search
            if (searchToggleMobile) {
                searchToggleMobile.addEventListener('click', openSearch);
            }
            if (searchToggleDesktop) {
                searchToggleDesktop.addEventListener('click', openSearch);
            }
            if (closeSearch) {
                closeSearch.addEventListener('click', closeSearchFunc);
            }
            if (searchOverlay) {
                searchOverlay.addEventListener('click', closeSearchFunc);
            }

            // Fungsi untuk menampilkan state kosong
            function showEmptyState() {
                searchEmpty.classList.remove('hidden');
                searchLoading.classList.add('hidden');
                searchNoResults.classList.add('hidden');
                searchResultsContainer.classList.add('hidden');
            }

            // Fungsi untuk menampilkan loading
            function showLoading() {
                searchEmpty.classList.add('hidden');
                searchLoading.classList.remove('hidden');
                searchNoResults.classList.add('hidden');
                searchResultsContainer.classList.add('hidden');
            }

            // Fungsi untuk menampilkan hasil
            function showResults(filteredProducts) {
                searchEmpty.classList.add('hidden');
                searchLoading.classList.add('hidden');

                if (filteredProducts.length === 0) {
                    searchNoResults.classList.remove('hidden');
                    searchResultsContainer.classList.add('hidden');
                } else {
                    searchNoResults.classList.add('hidden');
                    searchResultsContainer.classList.remove('hidden');

                    // Clear previous results
                    searchResultsContainer.innerHTML = '';

                    // Add new results
                    filteredProducts.forEach(product => {
                        const productElement = productTemplate.content.cloneNode(true);

                        // Set product data
                        productElement.querySelector('img').src = product.image;
                        productElement.querySelector('img').alt = product.name;
                        productElement.querySelector('h3').textContent = product.name;
                        productElement.querySelector('p').textContent = product.description;
                        productElement.querySelector('.font-bold').textContent = product.price;

                        // Add to cart functionality
                        const addToCartBtn = productElement.querySelector('button');
                        addToCartBtn.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();

                            const icon = this.querySelector('i');
                            const originalClass = icon.className;

                            icon.className = 'fas fa-check';
                            this.style.backgroundColor = '#10B981';

                            setTimeout(() => {
                                icon.className = originalClass;
                                this.style.backgroundColor = '#FA812F';
                            }, 1500);

                            alert(`Produk ${product.name} berhasil ditambahkan ke keranjang!`);
                        });

                        searchResultsContainer.appendChild(productElement);
                    });
                }
            }

            // Fungsi untuk melakukan pencarian
            function performSearch(query) {
                if (query.length < 2) {
                    showEmptyState();
                    return;
                }

                showLoading();

                // Simulasi delay pencarian
                setTimeout(() => {
                    const filteredProducts = products.filter(product =>
                        product.name.toLowerCase().includes(query.toLowerCase()) ||
                        product.description.toLowerCase().includes(query.toLowerCase()) ||
                        product.category.toLowerCase().includes(query.toLowerCase())
                    );

                    showResults(filteredProducts);
                }, 500);
            }

            // Event listener untuk input search
            if (searchInput) {
                let searchTimeout;
                searchInput.addEventListener('input', function() {
                    clearTimeout(searchTimeout);
                    const query = this.value.trim();

                    searchTimeout = setTimeout(() => {
                        performSearch(query);
                    }, 300);
                });
            }

            // Sidebar toggle functionality
            const menuToggle = document.getElementById('menu-toggle');
            const closeSidebar = document.getElementById('close-sidebar');
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebar-overlay');

            function openSidebar() {
                sidebar.classList.add('open');
                sidebarOverlay.classList.add('open');
                document.body.style.overflow = 'hidden';
            }

            function closeSidebarFunc() {
                sidebar.classList.remove('open');
                sidebarOverlay.classList.remove('open');
                document.body.style.overflow = 'auto';
            }

            if (menuToggle) {
                menuToggle.addEventListener('click', openSidebar);
            }
            if (closeSidebar) {
                closeSidebar.addEventListener('click', closeSidebarFunc);
            }
            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebarFunc);
            }

            // Skin type buttons functionality
            const skinTypeButtons = document.querySelectorAll('.skin-type-btn');
            const skinContents = document.querySelectorAll('.skin-content');

            skinTypeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Hapus kelas active dari semua tombol dan reset style
                    skinTypeButtons.forEach(btn => {
                        btn.classList.remove('active');
                        btn.style.backgroundColor = '';
                        btn.style.color = '';
                        btn.style.borderColor = '';
                    });

                    // Tambah kelas active ke tombol yang diklik
                    this.classList.add('active');
                    this.style.backgroundColor = '#FA812F';
                    this.style.color = 'white';
                    this.style.borderColor = '#FA812F';

                    // Sembunyikan semua konten
                    skinContents.forEach(content => {
                        content.classList.add('hidden');
                    });

                    // Tampilkan konten yang sesuai
                    const skinType = this.getAttribute('data-type');
                    const targetContent = document.getElementById(`skin-${skinType}`);
                    if (targetContent) {
                        targetContent.classList.remove('hidden');
                    }
                });
            });

            // Set active state untuk tombol default
            const defaultButton = document.querySelector('.skin-type-btn.active');
            if (defaultButton) {
                defaultButton.style.backgroundColor = '#FA812F';
                defaultButton.style.color = 'white';
                defaultButton.style.borderColor = '#FA812F';
            }

            // Product card hover effect
            const productCards = document.querySelectorAll('.product-card');

            productCards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.boxShadow = '0 10px 25px rgba(0,0,0,0.1)';
                });

                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.style.boxShadow = '0 4px 6px rgba(0,0,0,0.05)';
                });
            });

            // Add to cart functionality untuk semua tombol keranjang
            const addToCartButtons = document.querySelectorAll('.btn-block');
            addToCartButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();

                    const icon = this.querySelector('i');
                    const originalClass = icon.className;
                    const originalText = this.querySelector('span').textContent;

                    // Ubah icon dan teks
                    icon.className = 'fas fa-check';
                    this.querySelector('span').textContent = 'Ditambahkan!';
                    this.style.backgroundColor = '#10B981';

                    // Reset setelah 1.5 detik
                    setTimeout(() => {
                        icon.className = originalClass;
                        this.querySelector('span').textContent = originalText;
                        this.style.backgroundColor = '#FA812F';
                    }, 1500);

                    alert('Produk berhasil ditambahkan ke keranjang!');
                });
            });

            // Simulasi login/logout untuk demo
            const loginButton = document.querySelector('.bottom-nav a:nth-child(4)');
            let isLoggedIn = false;

            if (loginButton) {
                loginButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    isLoggedIn = !isLoggedIn;

                    if (isLoggedIn) {
                        this.innerHTML =
                            '<i class="fas fa-user text-2xl mb-1"></i><span class="text-xs font-medium">Profil</span>';
                        this.classList.add('logged-in');
                    } else {
                        this.innerHTML =
                            '<i class="fas fa-user text-2xl mb-1"></i><span class="text-xs font-medium">Masuk</span>';
                        this.classList.remove('logged-in');
                    }
                });
            }

            // Cart functionality (basic)
            const cartButton = document.querySelector('button .fa-shopping-cart').closest('button');
            if (cartButton) {
                cartButton.addEventListener('click', function() {
                    alert('Menuju ke keranjang belanja...');
                });
            }

            // Smooth scroll untuk anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    const target = document.querySelector(this.getAttribute('href'));
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Newsletter form submission
            const newsletterForm = document.querySelector('section.bg-primary-orange form');
            if (newsletterForm) {
                newsletterForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const emailInput = this.querySelector('input[type="email"]');
                    if (emailInput && emailInput.value) {
                        alert('Terima kasih! Anda telah berlangganan newsletter kami.');
                        emailInput.value = '';
                    } else {
                        alert('Silakan masukkan alamat email yang valid.');
                    }
                });
            }

            // Intersection Observer untuk animasi scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Terapkan animasi pada elemen yang diinginkan
            document.querySelectorAll('.product-card, .skin-content > div').forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });

            // Handle window resize
            let resizeTimer;
            window.addEventListener('resize', () => {
                document.body.classList.add('resize-animation-stopper');
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => {
                    document.body.classList.remove('resize-animation-stopper');
                }, 400);
            });

            // Tambahkan style untuk resize animation stopper
            const style = document.createElement('style');
            style.textContent = `
                .resize-animation-stopper * {
                    animation: none !important;
                    transition: none !important;
                }
            `;
            document.head.appendChild(style);
        });
    </script>

</body>

</html>
