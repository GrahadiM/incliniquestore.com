<?php

return [

    'top_nav' => [
        [
            'label' => 'HOME',
            'route' => 'frontend.index',
        ],
        [
            'label' => 'SHOP',
            'route' => 'frontend.shop.index',
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
            'route' => 'frontend.shop.index',
            'icon'  => 'fa-shopping-bag',
        ],
        [
            'key'   => 'blog',
            'label' => 'Blog',
            'route' => 'frontend.blog.index',
            'icon'  => 'fa-newspaper',
        ],
        [
            'key'   => 'cart',
            'label' => 'Cart',
            'route' => 'frontend.cart.index',
            'icon'  => 'fa-shopping-cart',
        ],
        [
            'key'   => 'account',
            'label' => 'Akun',
            'route' => 'login',
            'icon'  => 'fa-user',
        ],
    ],

    'side_nav' => [
        [
            'key'   => 'home',
            'label' => 'HOME',
            'route' => 'frontend.index',
            'icon'  => 'fa-home',
        ],
        [
            'key'   => 'shop',
            'label' => 'SHOP ALL',
            'route' => 'frontend.shop.index',
            'icon'  => 'fa-shopping-bag',
        ],
        [
            'key'   => 'blog',
            'label' => 'BEAUTY INSIDER',
            'route' => 'frontend.blog.index',
            'icon'  => 'fa-newspaper',
        ],
        // [
        //     'key'   => 'about',
        //     'label' => 'ABOUT US',
        //     'route' => 'frontend.about',
        //     'icon'  => 'fa-info-circle',
        // ],
        // [
        //     'key'   => 'career',
        //     'label' => 'CAREER',
        //     'route' => 'frontend.career.index',
        //     'icon'  => 'fa-envelope',
        // ],
    ],
];
