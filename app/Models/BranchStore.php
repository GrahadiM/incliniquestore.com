<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchStore extends Model
{
    protected $table = 'branch_stores';
    protected $guarded = [];

    // Scope active
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'branch_store_id');
    }
}
