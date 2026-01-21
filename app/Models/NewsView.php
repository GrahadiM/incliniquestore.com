<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsView extends Model
{
    protected $fillable = [
        'news_id',
        'user_id',
        'ip_address',
        'user_agent',
        'view_date'
    ];

    public function news()
    {
        return $this->belongsTo(News::class);
    }
}
