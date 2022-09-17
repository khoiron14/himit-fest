<?php

namespace App\Models;

use App\Enums\StepStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    use HasFactory;

    protected $casts = [
        'step' => StepStatus::class,
    ];

    protected $fillable = [
        'profile_id',
        'step',
    ];
}
