<?php

namespace App\Http\Controllers\Frontend;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BlogController extends Controller
{
    public function index()
    {
        $data = News::with(['author'])->where('status', 'published')->latest()->paginate(12);

        return view('frontend.blog.index', [
            'data' => $data,
        ]);
    }

    public function detail($slug)
    {
        $data = News::with(['author'])->where('status', 'published')->where('slug', $slug)->first();
        $data->increment('views');

        return view('frontend.blog.detail', [
            'data' => $data,
        ]);
    }
}
