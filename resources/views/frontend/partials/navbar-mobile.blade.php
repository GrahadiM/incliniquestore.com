<!-- Bottom Navigation for Mobile & Tablet -->
<nav class="bottom-nav fixed bottom-0 w-full bg-white border-t border-gray-200 shadow-md lg:hidden z-50">
    <div class="max-w-lg mx-auto flex justify-between px-4">

        @foreach (config('menu.bottom_nav') as $menu)

            @php
                /**
                 * DEFAULT VALUE
                 */
                $label = $menu['label'];
                $routeName = $menu['route'];

                /**
                 * ACCOUNT / LOGIN HANDLER
                 */
                if ($menu['key'] === 'account') {
                    if (auth()->check()) {
                        $label = 'Dashboard';
                        $routeName = 'customer.dashboard';
                    } else {
                        $label = 'Login';
                        $routeName = 'login';
                    }
                }

                /**
                 * ACTIVE STATE
                 */
                $isActive = false;

                // Exact match
                if (request()->routeIs($routeName)) {
                    $isActive = true;
                }

                // Grouped route matching
                if ($menu['key'] === 'shop' && request()->routeIs('frontend.shop.*')) {
                    $isActive = true;
                }

                if ($menu['key'] === 'blog' && request()->routeIs('frontend.blog.*')) {
                    $isActive = true;
                }

                if ($menu['key'] === 'cart' && request()->routeIs('frontend.cart.*')) {
                    $isActive = true;
                }

                if ($menu['key'] === 'account' && auth()->check() && request()->routeIs('customer.*')) {
                    $isActive = true;
                }
            @endphp

            <a
                href="{{ route($routeName) }}"
                class="flex flex-col items-center justify-center py-2 px-4
                {{ $isActive ? 'text-primary-orange' : 'text-gray-700' }}
                hover:text-primary-orange transition-colors"
            >
                <i class="fas {{ $menu['icon'] }} text-xl"></i>
                <span class="text-xs font-medium mt-1">{{ $label }}</span>
            </a>

        @endforeach

    </div>
</nav>
