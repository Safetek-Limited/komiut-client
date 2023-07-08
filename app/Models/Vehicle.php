<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'plate',
        'fleet_no',
        'till_number',
        'merchant_short_code',
        'sacco_id',
        'user_id',
        'status',
    ];

    public function sacco(): HasOne
    {
        return $this->hasOne(Sacco::class, 'id', 'sacco_id');
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
