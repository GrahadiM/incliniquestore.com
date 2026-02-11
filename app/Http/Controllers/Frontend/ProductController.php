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
        $data = Product::with(['category', 'images'])->where('slug', $slug)->where('status', 'published')->firstOrFail();

        // =============================
        // AI MEMORY (SESSION BASED)
        // =============================
        $viewed = session()->get('ai_viewed_products', []);
        array_unshift($viewed, $data->id);
        $viewed = array_unique($viewed);
        $viewed = array_slice($viewed, 0, 10); // max memory
        session()->put('ai_viewed_products', $viewed);

        // =============================
        // AI RECOMMENDATION ENGINE
        // =============================
        $recommendations = Product::where('status', 'published')
            ->where('id', '!=', $data->id)
            ->where(function ($q) use ($data, $viewed) {

                // 1️⃣ Same category
                $q->where('category_id', $data->category_id)

                // 2️⃣ Viewed history
                ->orWhereIn('id', $viewed);

            })
            ->whereBetween('price', [
                $data->price * 0.7,
                $data->price * 1.4
            ])
            ->orderByRaw("
                CASE
                    WHEN category_id = {$data->category_id} THEN 3
                    WHEN id IN (" . implode(',', $viewed ?: [0]) . ") THEN 2
                    ELSE 1
                END DESC
            ")
            ->orderByDesc('views')
            ->limit(8)
            ->get();

        // =============================
        // FALLBACK (POPULAR)
        // =============================
        if ($recommendations->count() < 4) {
            $fallback = Product::where('status', 'published')
                ->where('id', '!=', $data->id)
                ->orderByDesc('views')
                ->limit(4)
                ->get();

            $recommendations = $recommendations->merge($fallback)->unique('id')->take(8);
        }

        return view('frontend.products.detail', [
            'data' => $data,
            'recommendations' => $recommendations,
        ]);
    }
}
