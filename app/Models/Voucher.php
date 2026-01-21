<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'vouchers';
    protected $fillable = [
        'branch_store_id',
        'member_level_id',
        'code',
        'name',
        'type',
        'value',
        'min_transaction',
        'start_date',
        'end_date',
        'quota',
        'used',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function branch()
    {
        return $this->belongsTo(BranchStore::class, 'branch_store_id');
    }

    public function memberLevel()
    {
        return $this->belongsTo(MemberLevel::class, 'member_level_id');
    }

    public function isExpired()
    {
        return $this->end_date && now()->gt($this->end_date);
    }

    public function isAvailable()
    {
        if ($this->quota === null) return true;
        return $this->used < $this->quota;
    }
}
