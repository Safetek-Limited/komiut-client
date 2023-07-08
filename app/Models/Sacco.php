<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Sacco extends Model
{
    use HasFactory;

    protected $fillable =[
        "name",
        "phone_number",
        "motto",
        "pay_bill",
        "consumer_key",
        "consumer_secret",
        "passkey",
        "status",
        "created_by"

    ];

    public function created_by(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }
}
