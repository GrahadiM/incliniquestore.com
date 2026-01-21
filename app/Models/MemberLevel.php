<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberLevel extends Model
{
    protected $table = 'member_levels';
    protected $guarded = [];

    // Scope active
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'member_level_id');
    }

    public function vouchers()
    {
        return $this->hasMany(Voucher::class, 'member_level_id');
    }
}
