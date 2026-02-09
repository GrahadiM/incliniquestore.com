<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index($slug)
    {
        if ($slug == 'all') {
            return redirect()->route('frontend.shop.index');
        }

        $category = Category::where('slug', $slug)->first();
        $data['products'] = Product::with(['category'])->where('status', 'published')->where('category_id', $category->id)->latest()->paginate(12);
        $data['categories'] = Category::all();
        $data['all_products_count'] = Product::where('status', 'published')->count();

        return view('frontend.products.index', [
            'data' => $data,
        ]);
    }
}
