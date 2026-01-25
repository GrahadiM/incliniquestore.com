
<!-- Bottom Navigation for Mobile & Tablet -->
<nav class="bottom-nav fixed bottom-0 w-full bg-white border-t border-gray-200 shadow-md lg:hidden z-50">
    <div class="max-w-lg mx-auto flex justify-between px-4">

        @foreach (config('menu.bottom_nav') as $menu)

            @php
                $label = $menu['label'];
                $route = $menu['route'];

                if ($menu['key'] === 'account') {
                    if (auth()->check()) {
                        $label = 'Account';
                        $route = 'customer.dashboard';
                    } else {
                        $label = 'Login';
                        $route = 'login';
                    }
                }

                $isActive = request()->routeIs($route);
            @endphp

            <a href="{{ route($route) }}"
               class="flex flex-col items-center justify-center py-2 px-4
                      {{ $isActive ? 'text-primary-orange border-b-2 border-primary-orange' : 'text-gray-700' }}
                      hover:text-primary-orange transition-colors">

                <i class="fas {{ $menu['icon'] }} text-2xl"></i>
                <span class="text-xs font-medium">{{ $label }}</span>
            </a>

        @endforeach

    </div>
</nav>
