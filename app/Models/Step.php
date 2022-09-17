<?php

namespace App\Models;

use App\Enums\StepStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Step extends Model
{
    use HasFactory;


    protected $fillable = [
        'status',
    ];

    protected $casts = [
        'status' => StepStatus::class,
    ];
}
