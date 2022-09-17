<?php

namespace App\Models;

use Carbon\Carbon;
use App\Enums\StepStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $appends = [
        'file_url',
    ];

    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    protected function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->file ? $this->file->url : null,
        );
    }
}
