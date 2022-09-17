<?php

namespace App\Models;

use App\Enums\PassStatus;
use App\Enums\StepStatus;
use App\Enums\ProfileType;
use App\Models\Submission;
use App\Enums\CompetitionType;
use App\Enums\SubmissionStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'leader_name',
        'team_name',
        'institution',
        'competition'
    ];

    protected $appends = [
        'email',
        'identity_url',
        'pending_submission',
        'allow_upload',
    ];

    protected $casts = [
        'type' => ProfileType::class,
        'competition' => CompetitionType::class,
        'pass_status' => PassStatus::class
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function submissions()
    {
        return $this->hasMany(Submission::class);
    }

    public function identity()
    {
        return $this->morphOne(File::class, 'fileable');
    }

    protected function identityUrl(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->identity ? $this->identity->url : null,
        );
    }

    protected function email(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->user->email,
        );
    }

    protected function allowUpload(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (Step::first()->status = StepStatus::Step1) {
                    return $this->type != null;
                } else if (Step::first()->status = StepStatus::Step2) {
                    return ($this->type != null) && ($this->is_paid != 0) && ($this->pass_status == PassStatus::Step1);
                }
            },
        );
    }

    protected function pendingSubmission(): Attribute
    {
        return Attribute::make(
            get: function () {
                $submission = $this->submissions()
                    ->where('step', Step::first()->status)
                    ->where('status', SubmissionStatus::Pending)
                    ->first();

                return $submission != null ? true : false;
            },
        );
    }
}
