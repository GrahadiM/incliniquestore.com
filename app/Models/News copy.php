<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $table = 'news';
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'thumbnail',
        'is_featured',
        'status',
        'views',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'user_id'
    ];

    public function viewsLogs()
    {
        return $this->hasMany(NewsView::class);
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
