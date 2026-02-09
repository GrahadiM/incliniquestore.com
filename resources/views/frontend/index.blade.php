@extends('layouts.frontend')

@push('meta')
    {{-- @php
        $title = 'TESTING';
        $description = 'TESTING';
        $keywords = 'TESTING';
        $author = 'TESTING';
        $copyright = 'TESTING';
    @endphp --}}
    @include('frontend.partials.meta-home')
@endpush

@section('content')

    <!-- Hero Section -->
    <section class="hero-section py-8 rounded-br-[24px]">
        <div class="w-full lg:max-w-7xl mx-auto px-8 flex flex-col lg:flex-row items-center gap-2">
            <div class="w-full lg:w-3/5 xl:w-1/2 mb-10 lg:mb-0">
                <h1 class="text-4xl lg:text-5xl font-bold text-gray-800 mb-4">
                    Awali <span class="text-primary-orange">Skin Renewal</span> dengan Rutinitas Terbaik
                </h1>
                <p class="text-lg text-gray-800 mb-8">
                    Rangkaian InClinique Renewal Series diformulasikan khusus untuk mendukung pembaruan kulit alami.
                    Hasil kulit lebih sehat dan bercahaya dalam 14 hari pertama penggunaan.
                </p>
                <div class="flex flex-col sm:flex-row space-y-1 md:space-y-0 space-x-0 md:space-x-1 justify-center lg:justify-start">
                    <button onclick="window.location.href='{{ route('frontend.shop.index') }}';" class="border border-primary-orange bg-primary-orange text-white px-6 py-3 rounded-bl-[48px] rounded-tr-[48px] md:rounded-bl-[12px] md:rounded-tr-[12px] font-semibold hover:bg-transparent hover:text-primary-orange transition duration-300">
                        Belanja Sekarang
                    </button>
                    <button onclick="window.location.href='{{ route('frontend.locations.index') }}';" class="border border-primary-orange bg-primary-orange text-white px-6 py-3 rounded-br-[48px] rounded-tl-[48px] md:rounded-br-[12px] md:rounded-tl-[12px] font-semibold hover:bg-transparent hover:text-primary-orange transition duration-300">
                        Lokasi Toko Kami
                    </button>
                </div>
            </div>
            <div class="w-full lg:w-2/5 xl:w-1/2 flex justify-center">
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1556228578-8c89e6adf883?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1000&q=80" alt="Skincare Products" class="rounded-lg shadow-xl w-full max-w-md">
                    <div class="absolute -top-4 -right-4 bg-white p-4 rounded-lg shadow-lg">
                        <p class="text-sm font-semibold text-gray-800">
                            Tampil <span class="font-bold text-primary-orange">Percaya Diri</span> dengan Kulit Sehat
                        </p>
                    </div>
                    <div class="absolute -bottom-4 -left-4 bg-white p-4 rounded-lg shadow-lg">
                        <p class="text-sm font-semibold text-gray-800">
                            Melayani lebih dari <span class="font-bold text-primary-orange">10.000+</span> pelanggan
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Skin Type Recommendation -->
    <section class="py-16 bg-white rounded-tl-[24px] rounded-br-[24px]">
        <div class="w-full lg:max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Solusi Cerdas dari Produk sesuai kebutuhan Anda</h2>
                <p class="text-gray-800 max-w-2xl mx-auto">
                    Temukan rekomendasi produk yang dipersonalisasi berdasarkan jenis kulit Anda. Setiap formulasi dirancang khusus untuk memberikan solusi optimal sesuai karakteristik kulit.
                </p>
            </div>

            @php
                $skinTypes = [
                    ['label' => 'KULIT NORMAL', 'key' => 'normal'],
                    ['label' => 'KULIT BERMINYAK', 'key' => 'oily'],
                    ['label' => 'KULIT KERING', 'key' => 'dry'],
                    ['label' => 'KULIT SENSITIF', 'key' => 'sensitive'],
                    ['label' => 'KOMBINASI', 'key' => 'combination'],
                ];

                $activeSkin = 'normal';
            @endphp

            <div class="flex flex-wrap justify-center gap-4 mb-12">
                @foreach ($skinTypes as $type)
                    <button class="skin-type-btn {{ $activeSkin == $type['key'] ? 'active' : '' }} px-4 py-2 lg:px-6 lg:py-3 rounded-full border border-gray-300 hover:border-primary-orange hover:bg-primary-orange hover:text-white transition duration-300 text-sm lg:text-base font-semibold" data-type="{{ $type['key'] }}">{{ $type['label'] }}</button>
                @endforeach
            </div>

            @php
                $skinTypes = [
                    'normal' => [
                        'label' => 'KULIT NORMAL',
                        'sublabel' => 'Seimbang & Mudah Dirawat',
                        'description' => 'Produk untuk menjaga keseimbangan alami kulit normal.',
                        'items' => [
                            [
                                'icon' => 'fas fa-pump-soap',
                                'icon_bg' => 'bg-orange-100',
                                'icon_color' => 'text-primary-orange',
                                'title' => 'Gentle Cleanser',
                                'desc' => 'Pembersih wajah dengan formula lembut yang membersihkan secara mendalam tanpa mengganggu minyak alami dan keseimbangan pH kulit.',
                            ],
                            [
                                'icon' => 'fas fa-tint',
                                'icon_bg' => 'bg-yellow-100',
                                'icon_color' => 'text-primary-yellow',
                                'title' => 'Light Moisturizer',
                                'desc' => 'Pelembap dengan tekstur ringan yang memberikan hidrasi optimal untuk menjaga elastisitas dan kesehatan kulit sepanjang hari.',
                            ],
                            [
                                'icon' => 'fas fa-shield-alt',
                                'icon_bg' => 'bg-red-100',
                                'icon_color' => 'text-primary-red',
                                'title' => 'Daily Sunscreen',
                                'desc' => 'Perlindungan harian SPF 30+ dengan teknologi broad-spectrum dan tekstur tidak berminyak untuk melindungi kulit dari paparan UVA/UVB.',
                            ],
                        ],
                    ],

                    'oily' => [
                        'label' => 'KULIT BERMINYAK',
                        'sublabel' => 'Kontrol Minyak & Pori',
                        'description' => 'Solusi untuk kulit berminyak dan pori-pori besar.',
                        'items' => [
                            [
                                'icon' => 'fas fa-wind',
                                'icon_bg' => 'bg-green-100',
                                'icon_color' => 'text-green-600',
                                'title' => 'Oil-Control Cleanser',
                                'desc' => 'Pembersih dengan teknologi pengontrol minyak dan kandungan salicylic acid untuk membersihkan pori-pori tanpa menyebabkan over-drying.',
                            ],
                            [
                                'icon' => 'fas fa-leaf',
                                'icon_bg' => 'bg-blue-100',
                                'icon_color' => 'text-blue-600',
                                'title' => 'Mattifying Moisturizer',
                                'desc' => 'Pelembap berbasis gel dengan finish matte yang menghidrasi kulit sekaligus mengurangi kilap berlebih sepanjang hari.',
                            ],
                            [
                                'icon' => 'fas fa-magic',
                                'icon_bg' => 'bg-purple-100',
                                'icon_color' => 'text-purple-600',
                                'title' => 'Pore Refining Serum',
                                'desc' => 'Serum dengan kombinasi niacinamide dan zinc PCA yang membantu meminimalkan tampilan pori-pori dan menyerap kelebihan minyak.',
                            ],
                        ],
                    ],

                    'dry' => [
                        'label' => 'KULIT KERING',
                        'sublabel' => 'Hidrasi Maksimal',
                        'description' => 'Nutrisi intensif untuk kulit kering & dehidrasi.',
                        'items' => [
                            [
                                'icon' => 'fas fa-cloud-rain',
                                'icon_bg' => 'bg-yellow-100',
                                'icon_color' => 'text-yellow-600',
                                'title' => 'Hydrating Cleanser',
                                'desc' => 'Pembersih berbasis krim yang diperkaya dengan hyaluronic acid dan ceramides untuk membersihkan sekaligus mempertahankan kelembapan kulit.',
                            ],
                            [
                                'icon' => 'fas fa-tint',
                                'icon_bg' => 'bg-pink-100',
                                'icon_color' => 'text-pink-600',
                                'title' => 'Rich Cream Moisturizer',
                                'desc' => 'Pelembap intensif dengan triple-action formula yang mengandung ceramides, squalane, dan shea butter untuk memperbaiki skin barrier.',
                            ],
                            [
                                'icon' => 'fas fa-water',
                                'icon_bg' => 'bg-indigo-100',
                                'icon_color' => 'text-indigo-600',
                                'title' => 'Hyaluronic Acid Serum',
                                'desc' => 'Serum konsentrat dengan multi-molecular hyaluronic acid yang memberikan hidrasi berlapis dari permukaan hingga ke dalam kulit.',
                            ],
                        ],
                    ],

                    'sensitive' => [
                        'label' => 'KULIT SENSITIF',
                        'sublabel' => 'Lembut & Menenangkan',
                        'description' => 'Perawatan lembut untuk kulit sensitif & reaktif.',
                        'items' => [
                            [
                                'icon' => 'fas fa-heart',
                                'icon_bg' => 'bg-green-100',
                                'icon_color' => 'text-green-600',
                                'title' => 'Calming Cleanser',
                                'desc' => 'Pembersih hypoallergenic dengan ekstrak chamomile dan oat yang membersihkan secara lembut dan mengurangi kemerahan.',
                            ],
                            [
                                'icon' => 'fas fa-shield-virus',
                                'icon_bg' => 'bg-blue-100',
                                'icon_color' => 'text-blue-600',
                                'title' => 'Barrier Repair Cream',
                                'desc' => 'Formula perbaikan skin barrier dengan centella asiatica, panthenol, dan peptides yang memperkuat pertahanan kulit sensitif.',
                            ],
                            [
                                'icon' => 'fas fa-spa',
                                'icon_bg' => 'bg-purple-100',
                                'icon_color' => 'text-purple-600',
                                'title' => 'Soothing Toner',
                                'desc' => 'Toner bebas alkohol dan fragrance dengan colloidal oatmeal untuk menenangkan, mengurangi iritasi, dan mempersiapkan kulit.',
                            ],
                        ],
                    ],

                    'combination' => [
                        'label' => 'KOMBINASI',
                        'sublabel' => 'Seimbang & Terhidrasi',
                        'description' => 'Perawatan untuk kulit kombinasi yang seimbang.',
                        'items' => [
                            [
                                'icon' => 'fas fa-balance-scale',
                                'icon_bg' => 'bg-sky-100',
                                'icon_color' => 'text-sky-600',
                                'title' => 'Balancing Cleanser',
                                'desc' => 'Pembersih multitasking yang efektif mengangkat kelebihan minyak di area T-zone tanpa membuat area pipi terasa kering.',
                            ],
                            [
                                'icon' => 'fas fa-adjust',
                                'icon_bg' => 'bg-teal-100',
                                'icon_color' => 'text-teal-600',
                                'title' => 'Dual Moisturizer',
                                'desc' => 'Pelembap inovatif dengan teknologi zona-specific yang memberikan hidrasi berbeda sesuai kebutuhan setiap area kulit.',
                            ],
                            [
                                'icon' => 'fas fa-sync-alt',
                                'icon_bg' => 'bg-cyan-100',
                                'icon_color' => 'text-cyan-600',
                                'title' => 'Zone Control Serum',
                                'desc' => 'Serum cerdas dengan kombinasi niacinamide untuk area berminyak dan hyaluronic acid untuk area kering, menciptakan keseimbangan optimal.',
                            ],
                        ],
                    ],
                ];
            @endphp

            @foreach ($skinTypes as $key => $type)
            <!-- Content for {{ $key }} Skin (Default) -->
                <div
                    id="skin-{{ $key }}"
                    class="skin-content grid grid-cols-1 md:grid-cols-3 gap-8
                        {{ $activeSkin !== $key ? 'hidden' : '' }}"
                >

                    @foreach ($type['items'] as $item)
                        @include('frontend.partials.skin-card', ['item' => $item])
                    @endforeach

                </div>
            @endforeach
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 bg-primary-light">
        <div class="w-full lg:max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">Produk Terlaris</h2>
                <a href="{{ route('frontend.shop.index') }}" class="hidden md:inline-block bg-primary-orange text-white px-6 py-3 rounded-br-[16px] rounded-tl-[16px] font-medium hover:shadow-lg hover:shadow-orange-500/50 transition duration-300">
                    Lihat Semua
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @foreach ($data['products'] as $product)
                    @include('frontend.partials.product-card', ['product' => $product])
                @endforeach
            </div>

            <!-- Mobile & Tablet View All Button -->
            <div class="md:hidden mt-16 text-center">
                <a href="{{ route('frontend.shop.index') }}" class="block bg-primary-orange text-white px-6 py-3 rounded-br-[16px] rounded-tl-[16px] font-medium hover:shadow-lg hover:shadow-orange-500/50 transition duration-300">
                    Lihat Semua
                </a>
            </div>
        </div>
    </section>

    {{-- <!-- Testimonials -->
    <section class="py-16 bg-white">
        <div class="w-full lg:max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800 mb-4">Apa Kata Pelanggan Kami</h2>
                <p class="text-gray-800 max-w-2xl mx-auto">
                    Lihat pengalaman nyata dari ribuan pelanggan yang telah merasakan manfaat produk Inclinique Store
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <div class="bg-primary-light p-6 rounded-lg">
                    <div class="flex items-center mb-4">
                        <img src="https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=100&q=80"
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
                    <p class="text-gray-800">
                        "Kulit saya yang sensitif akhirnya menemukan produk yang cocok. Gentle Cleanser tidak membuat kulit saya iritasi dan benar-benar membersihkan dengan lembut."
                    </p>
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
                    <p class="text-gray-800">
                        "Sebagai pria dengan kulit berminyak, saya kesulitan menemukan produk yang
                        tepat. Setelah menggunakan rangkaian untuk kulit berminyak, wajah saya terasa lebih segar dan
                        tidak mengilap."
                    </p>
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
                    <p class="text-gray-800">
                        "Hydrating Serum benar-benar mengubah kulit kering saya. Dalam 2 minggu,
                        kulit terasa lebih lembap dan kenyal. Sekarang tidak perlu lagi memakai pelembap tambahan."
                    </p>
                </div>
            </div>
        </div>
    </section> --}}

    <!-- Offline Store Locations -->
    @include('frontend.store.index')

    <!-- Featured News -->
    <section class="py-16 bg-primary-light">
        <div class="w-full lg:max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center mb-12">
                <h2 class="text-3xl font-bold text-gray-800">
                    Berita & Artikel Terbaru
                </h2>

                <a href="{{ route('frontend.blog.index') }}"
                class="hidden md:inline-block bg-primary-orange text-white px-6 py-3 rounded-br-[16px] rounded-tl-[16px] font-medium hover:shadow-lg hover:shadow-orange-500/50 transition duration-300">
                    Lihat Semua
                    <i class="fas fa-arrow-right ml-2"></i>
                </a>
            </div>

            @if($data['news']->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                    @foreach ($data['news'] as $item)
                        @include('frontend.partials.news-card', ['news' => $item])
                    @endforeach
                </div>
            @else
                <div class="text-center py-12 text-gray-500">
                    Belum ada berita yang dipublikasikan.
                </div>
            @endif

            <!-- Mobile View All -->
            <div class="md:hidden mt-16 text-center">
                <a href="{{ route('frontend.blog.index') }}" class="block bg-primary-orange text-white px-6 py-3 rounded-br-[16px] rounded-tl-[16px] font-medium hover:shadow-lg hover:shadow-orange-500/50 transition duration-300">
                    Lihat Semua
                </a>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="py-16 bg-primary-orange text-white">
        <div class="w-full lg:max-w-7xl mx-auto px-4 text-center">
            <h2 class="text-3xl font-bold mb-4">Dapatkan Tips Perawatan Kulit Eksklusif</h2>
            <p class="max-w-2xl mx-auto mb-8">
                Berlangganan newsletter kami dan dapatkan tips perawatan kulit,
                promo spesial, dan informasi produk terbaru langsung di inbox Anda.
            </p>

            <div class="max-w-md mx-auto flex flex-col sm:flex-row">
                <input type="email" placeholder="Alamat email Anda" class="border-0 flex-grow px-4 py-3 rounded-tl-[24px] text-gray-800 focus:outline-none">
                <button class="bg-red-600 px-6 py-3 rounded-br-[24px] font-medium hover:bg-red-800 transition duration-300">Berlangganan</button>
            </div>
        </div>
    </section>

@endsection
