<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'whatsapp',
        'gender',
        'branch_store_id',
        'member_level_id',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Scope active
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function branch()
    {
        return $this->belongsTo(BranchStore::class, 'branch_store_id');
    }

    public function memberLevel()
    {
        return $this->belongsTo(MemberLevel::class, 'member_level_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function defaultAddress()
    {
        return $this->hasOne(Address::class)->where('is_default', true);
    }

    public function ensureDefaultAddress()
    {
        if (!$this->addresses()->where('is_default', true)->exists()) {
            $first = $this->addresses()->first();
            if ($first) {
                $first->update(['is_default' => true]);
            }
        }
    }

}
