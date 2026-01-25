<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::with(['category'])->where('status', 'published')->latest()->paginate(12);
        return view('frontend.products.index', [
            'data' => $data,
        ]);
    }

    public function detail($slug)
    {
        $data = Product::with(['category'])->where('status', 'published')->where('slug', $slug)->first();
        return view('frontend.products.detail', [
            'data' => $data,
        ]);
    }

    public function category($slug)
    {
        $data = Category::with(['products' => function ($query) {
            $query->where('status', 'published')->latest();
        }])->where('slug', $slug)->first();
        return view('frontend.products.category', [
            'data' => $data,
        ]);
    }
}
