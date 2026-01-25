<div
    class="bg-white rounded-br-[24px] rounded-tl-[24px] hover:shadow-lg hover:shadow-orange-500/50 transition duration-300"
>
    <!-- IMAGE -->
    <div
        class="relative cursor-pointer"
        onclick="goToProduct(this)"
        data-slug=""
    >
        <img
            src=""
            alt=""
            class="thumbnail w-full rounded-br-[12px] rounded-tl-[12px] aspect-square object-cover"
        >
    </div>

    <!-- CONTENT -->
    <div class="p-4">
        <h3
            class="name font-semibold text-sm text-gray-800 mb-1 cursor-pointer"
            onclick="goToProduct(this)"
            data-slug=""
        ></h3>

        <div class="space-y-0 mb-3">
            <span class="price font-bold text-primary-red text-lg"></span>
            <br>
            <span class="discounted-price text-gray-500 text-sm line-through"></span>
        </div>

        <!-- ADD TO CART -->
        <button
            class="btn-add-to-cart btn-block border border-primary-orange bg-primary-orange text-white text-sm font-semibold py-2 rounded-bl-[48px] rounded-tr-[48px] md:rounded-bl-[12px] md:rounded-tr-[12px] hover:bg-transparent hover:text-primary-orange transition duration-300 flex items-center justify-center space-x-2 mb-1"
            onclick="addToCartFromSearch(event, this)"
            data-id=""
        >
            <i class="fas fa-shopping-cart"></i>
            <span>Keranjang</span>
        </button>

        <!-- VIEW MORE -->
        <button
            class="btn-view-more btn-block border border-primary-orange bg-primary-orange text-white text-sm font-semibold py-2 rounded-br-[48px] rounded-tl-[48px] md:rounded-br-[12px] md:rounded-tl-[12px] hover:bg-transparent hover:text-primary-orange transition duration-300 flex items-center justify-center space-x-2"
            onclick="goToProduct(this)"
            data-slug=""
        >
            <i class="fas fa-eye"></i>
            <span>View More</span>
        </button>
    </div>
</div>

@push('scripts')
<script>
    /**
     * Add to cart (from search result)
     */
    function addToCartFromSearch(event, el) {
        event.preventDefault();
        event.stopPropagation();

        const productId = el.dataset.id;
        if (!productId) return;

        fetch("{{ route('frontend.cart.add') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                "Accept": "application/json"
            },
            body: JSON.stringify({
                product_id: productId,
                qty: 1
            })
        })
        .then(response => {
            if (response.status === 401) {
                window.location.href = "{{ route('login') }}";
                return;
            }
            return response.json();
        })
        .then(data => {
            if (!data) return;

            if (data.success) {
                showToast(data.message || 'Produk berhasil ditambahkan ke keranjang', 'success');
                updateCartBadge(data.cart_count ?? null);
            } else {
                showToast(data.message || 'Gagal menambahkan ke keranjang', 'error');
            }
        })
        .catch(() => {
            showToast('Terjadi kesalahan sistem', 'error');
        });
    }
</script>
@endpush
