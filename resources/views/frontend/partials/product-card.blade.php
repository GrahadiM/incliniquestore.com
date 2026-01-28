
<div class="hover:cursor-pointer bg-white rounded-br-[24px] rounded-tl-[24px] hover:shadow-lg hover:shadow-orange-500/50 transition duration-300">
    <div class="relative" onclick="window.location.href='{{ route('frontend.product.detail', ['slug' => $product?->slug]) }}';">
        <img src="{{ config('app.asset_url') . '/storage/' . $product?->thumbnail }}" alt="{{ $product?->name }}" class="w-full rounded-br-[12px] rounded-tl-[12px] aspect-square object-cover">

        @if ($product?->is_featured == 1)
            <span class="absolute -top-4 -right-2 rounded-br-[12px] rounded-tl-[12px] bg-primary-orange text-white text-xs font-medium px-4 py-2 hover:shadow-lg hover:shadow-orange-500/50 transition duration-300">
                BESTSELLER
            </span>
        @endif

        <span class="absolute -bottom-0 -right-0 rounded-br-[12px] rounded-tl-[12px] bg-primary-red text-white text-xs font-medium px-2 py-1 hover:shadow-lg hover:shadow-red-500/50 transition duration-300">
            {{ !$product?->discount ? 20 : $product?->discount }}%
        </span>
    </div>

    <div class="p-4">
        <h3 class="font-semibold text-sm text-gray-800 mb-1" onclick="window.location.href='{{ route('frontend.product.detail', ['slug' => $product?->slug]) }}';">
            {{ $product?->name }}
        </h3>

        <div class="space-y-0 mb-3">
            <div class="flex items-center space-x-2" onclick="window.location.href='{{ route('frontend.product.detail', ['slug' => $product?->slug]) }}';">
                <span class="font-bold text-primary-red text-lg">
                    Rp.{{ number_format($product?->price, 0, ',', '.') }}
                </span>

                <?php
                    $discountedPrice = !$product?->discount ? $product?->price + ($product?->price * 20) / 100 : $product?->price + ($product?->price * $product?->discount) / 100;
                ?>
                <span class="text-gray-500 text-sm line-through">
                    Rp.{{ number_format($discountedPrice, 0, ',', '.') }}
                </span>
            </div>
        </div>

        <button
            class="btn-add-to-cart btn-block border border-primary-orange bg-primary-orange text-white text-sm font-semibold py-2 rounded-bl-[48px] rounded-tr-[48px] md:rounded-bl-[12px] md:rounded-tr-[12px] hover:bg-transparent hover:text-primary-orange transition duration-300 flex items-center justify-center space-x-2 mb-1"
            onclick="addToCart({{ $product->id }}, event)"
        >
            <i class="fas fa-shopping-cart"></i>
            <span>Add to Cart</span>
        </button>

        <button
            class="btn-view-more btn-block border border-primary-orange bg-primary-orange text-white text-sm font-semibold py-2 rounded-br-[48px] rounded-tl-[48px] md:rounded-br-[12px] md:rounded-tl-[12px] hover:bg-transparent hover:text-primary-orange transition duration-300 flex items-center justify-center space-x-2"
            onclick="goToProduct(this)"
            data-slug="{{ $product?->slug }}"
        >
            <i class="fas fa-eye"></i>
            <span>View More</span>
        </button>
    </div>
</div>

@push('scripts')
    <script>
        function addToCart(productId, event) {
            if (event) {
                event.preventDefault();
                event.stopPropagation();
            }

            const button = event?.currentTarget;
            if (!button) return false;

            const icon = button.querySelector('i');
            const textSpan = button.querySelector('span');

            const originalIcon = icon.className;
            const originalText = textSpan.textContent;
            const originalBg = button.style.backgroundColor;

            button.disabled = true;
            icon.className = 'fas fa-spinner fa-spin';
            textSpan.textContent = 'Adding...';

            fetch("{{ route('frontend.cart.add') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json",
                    "Accept": "application/json",
                },
                body: JSON.stringify({
                    product_id: productId,
                    qty: 1
                })
            })
            .then(res => {
                if (res.status === 401) {
                    window.location.href = "{{ route('login') }}";
                    return null;
                }
                return res.json();
            })
            .then(data => {
                if (!data) return;

                if (data.success) {
                    icon.className = 'fas fa-check';
                    textSpan.textContent = 'Ditambahkan!';
                    button.style.backgroundColor = '#10B981';

                    if (typeof updateCartBadge === 'function' && data.cart_count !== undefined) {
                        updateCartBadge(data.cart_count);
                    }

                    if (typeof showToast === 'function') {
                        showToast(data.message, 'success');
                    }
                } else {
                    throw new Error(data.message || 'Gagal menambahkan ke keranjang');
                }
            })
            .catch(err => {
                icon.className = originalIcon;
                textSpan.textContent = originalText;

                if (typeof showToast === 'function') {
                    showToast(err.message || 'Terjadi kesalahan sistem', 'error');
                }
            })
            .finally(() => {
                setTimeout(() => {
                    button.disabled = false;
                    icon.className = originalIcon;
                    textSpan.textContent = originalText;
                    button.style.backgroundColor = originalBg;
                }, 1500);
            });

            return false;
        }
    </script>
@endpush
