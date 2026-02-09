<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Product;
use App\Models\BranchStore;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $data['products'] = Product::with(['category'])->where('status', 'published')->where('is_featured', 1)->orderByDesc('is_featured')->latest()->limit(4)->get();
        $data['news'] = News::where('status', 'published')->where('is_featured', 1)->orderByDesc('is_featured')->latest()->limit(3)->get();
        $data['stores'] = BranchStore::where('status', 'active')->get();

        return view('frontend.index', [
            'data' => $data
        ]);
    }

    public function search(Request $request)
    {
        $q = $request->q;

        return Product::where('status', 'published')
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                      ->orWhere('meta_keywords', 'like', "%{$q}%")
                      ->orWhere('meta_description', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get([
                'id',
                'name',
                'slug',
                'thumbnail',
            ]);
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function faq()
    {
        return view('frontend.faq');
    }

    public function privacyPolicy()
    {
        return view('frontend.privacy-policy');
    }

    public function termsAndConditions()
    {
        return view('frontend.terms-and-conditions');
    }
}
