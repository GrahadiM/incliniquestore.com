<?php

return [

    'top_nav' => [
        [
            'label' => 'HOME',
            'route' => 'frontend.index',
        ],
        [
            'label' => 'SHOP',
            'route' => 'frontend.product.index',
        ],
        [
            'label' => 'BLOG',
            'route' => 'frontend.blog.index',
        ],
        [
            'label' => 'ABOUT',
            'route' => 'frontend.about',
        ],
        [
            'label' => 'CAREER',
            'route' => 'frontend.career.index',
        ],
    ],

    'bottom_nav' => [
        [
            'key'   => 'home',
            'label' => 'Home',
            'route' => 'frontend.index',
            'icon'  => 'fa-home',
        ],
        [
            'key'   => 'shop',
            'label' => 'Shop',
            'route' => 'frontend.product.index',
            'icon'  => 'fa-shopping-bag',
        ],
        [
            'key'   => 'cart',
            'label' => 'Cart',
            'route' => 'frontend.cart.index',
            'icon'  => 'fa-shopping-cart',
        ],
        [
            'key'   => 'blog',
            'label' => 'Blog',
            'route' => 'frontend.blog.index',
            'icon'  => 'fa-newspaper',
        ],
        [
            'key'   => 'account',
            'label' => 'Akun',
            'route' => 'login',
            'icon'  => 'fa-user',
        ],
    ],

];
