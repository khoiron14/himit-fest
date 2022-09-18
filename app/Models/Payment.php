<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_id',
        'name',
        'status',
    ];

    protected $casts = [
        'status' => PaymentStatus::class,
    ];
}
