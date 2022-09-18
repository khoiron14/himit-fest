<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected $appends = [
        'file_url',
    ];

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }

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
