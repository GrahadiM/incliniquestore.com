<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    protected $table = 'web_settings';
    protected $fillable = [
        'site_name',
        'site_title',
        'site_description',
        'site_keywords',
        'site_author',
        'site_copyright',
        'site_url',
        'site_logo',
        'site_favicon',
        'site_email',
        'site_phone',
        'site_address',
        'facebook_link',
        'instagram_link',
        'thread_link',
        'tiktok_link',
        'twitter_link',
        'linkedin_link',
        'youtube_link',
    ];

    public static function current()
    {
        return self::firstOrFail();
    }
}
