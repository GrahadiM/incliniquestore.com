<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'name',
        'slug',
        'category_id',
        'price',
        'stock',
        'thumbnail',
        'is_featured',
        'description',
        'status',
        'views',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
    ];

    /* ================= RELATIONS ================= */

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /* ================= ACCESSORS ================= */

    public function getThumbnailUrlAttribute(): string
    {
        if (!$this->thumbnail) {
            return asset('assets/images/no-image.png');
        }

        return asset('storage/' . $this->thumbnail);
    }

    public function getPrimaryImageAttribute(): ?string
    {
        return $this->images()->value('image_path');
    }

    /* ================= SEO ================= */

    public function getSeoTitleAttribute(): string
    {
        return $this->meta_title ?: $this->name . ' | Incliniqué Store';
    }

    public function getSeoDescriptionAttribute(): string
    {
        return $this->meta_description
            ?: Str::limit(strip_tags($this->description), 160);
    }

    public function getSeoKeywordsAttribute(): string
    {
        if ($this->meta_keywords) {
            return $this->meta_keywords;
        }

        return implode(', ', array_filter([
            $this->name,
            $this->category?->name,
            'skincare',
            'beauty clinic',
            'incliniqué',
        ]));
    }
}
