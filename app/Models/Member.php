<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'membership_number',
        'first_name',
        'middle_name',
        'last_name',
        'email',
        'phone_number',
        'address',
        'membership_category',
        'membership_level',
        'birth_date',
        'status',
    ];

    protected static function booted(): void
    {
        static::creating(function (Member $member) {
            do {
                $membershipNumber = 'TRL-MEM-' . now()->format('Y') . '-' . Str::upper(Str::random(6));
            } while (self::where('membership_number', $membershipNumber)->exists());

            $member->membership_number = $membershipNumber;
        });
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(MembershipTransaction::class);
    }
}