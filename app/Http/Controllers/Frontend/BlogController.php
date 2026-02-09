<?php

namespace App\Http\Controllers\Frontend;

use App\Models\News;
use App\Models\NewsView;
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

    public function detail(Request $request, $slug)
    {
        $data = News::with(['author'])->where('status', 'published')->where('slug', $slug)->first();
        // $data->increment('views');
        $this->countView($data, $request);

        return view('frontend.blog.detail', [
            'data' => $data,
        ]);
    }

    protected function countView(News $news, Request $request)
    {
        if (!$news || !$news->id) return;
        if ($this->isBot($request->userAgent())) return;

        $ip = $request->ip();
        $userId = auth()->id();
        $today = now()->toDateString();

        $exists = NewsView::where('news_id', $news->id)
            ->whereDate('view_date', $today)
            ->where(function($q) use ($ip, $userId) {
                if ($userId) $q->where('user_id', $userId);
                else $q->where('ip_address', $ip);
            })
            ->exists();

        if (!$exists) {
            NewsView::create([
                'news_id' => $news->id,
                'user_id' => $userId,
                'ip_address' => $ip,
                'user_agent' => request()->userAgent(),
                'view_date' => $today,
            ]);

            $news->increment('views');
        }
    }

    protected function isBot($userAgent)
    {
        if (!$userAgent) return true;
        $bots = ['bot','crawl','spider','slurp','facebook','whatsapp'];
        foreach ($bots as $bot) if (stripos($userAgent, $bot) !== false) return true;
        return false;
    }
}
