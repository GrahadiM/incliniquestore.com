<script>
    /**
     * Redirect to product detail
     */
    function goToProduct(el) {
        const slug = el.dataset.slug;
        console.log(slug);

        if (!slug) {
            console.warn('Product slug not found');
            return;
        }

        const baseUrl = "{{ url('/products') }}";
        window.location.href = `${baseUrl}/${slug}`;
    }

    // Data produk untuk pencarian
    const products = [
        @foreach ($allProducts as $product)
            {
                id: {{ $product->id }},
                slug: "{{ $product->slug }}",
                name: "{{ addslashes($product->name) }}",
                category: "{{ addslashes($product->category->name) }}",
                price: "Rp.{{ number_format($product->price, 0, ',', '.') }}",
                discounted_price: "{{ $discounted_price = !$product?->discount ? 'Rp.'.number_format($product?->price + ($product?->price * 20) / 100) : 'Rp.'.number_format($product?->price + ($product?->price * $product?->discount) / 100) }}",
                thumbnail: "{{ asset('storage/' . $product->thumbnail) }}"
            },
        @endforeach
    ];

    console.log(products, 'Loaded products for search functionality');
    console.log(products[0], 'Loaded details of product for search functionality');

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
                    productElement.querySelector('.thumbnail').src = product.thumbnail;
                    productElement.querySelector('.thumbnail').alt = product.name;
                    productElement.querySelector('.name').textContent = product.name;
                    productElement.querySelector('.price').textContent = product.price;
                    productElement.querySelector('.discounted-price').textContent = product.discounted_price;
                    productElement.querySelector('[data-slug]').dataset.slug = product.slug;
                    productElement.querySelector('.btn-view-more').dataset.slug = product.slug;
                    productElement.querySelector('.btn-add-to-cart').dataset.id = product.id;

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
