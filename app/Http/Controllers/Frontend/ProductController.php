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
        $data['products'] = Product::with(['category'])->where('status', 'published')->latest()->paginate(12);
        $data['categories'] = Category::all();
        $data['all_products_count'] = Product::where('status', 'published')->count();

        return view('frontend.products.index', [
            'data' => $data,
        ]);
    }

    public function detail($slug)
    {
        $data = Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // AI Recommendation (Rule-based AI)
        $recommendations = Product::where('id', '!=', $data->id)
            ->where('category_id', $data->category_id)
            ->whereBetween('price', [
                $data->price * 0.7,
                $data->price * 1.3
            ])
            ->orderByDesc('views')
            ->limit(4)
            ->get();

        return view('frontend.products.detail', compact(
            'data',
            'recommendations'
        ));
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
