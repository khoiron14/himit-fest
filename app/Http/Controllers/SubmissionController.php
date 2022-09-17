<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Step;
use App\Models\Profile;
use App\Enums\StepStatus;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SubmissionController extends Controller
{
    public function store(Request $request, Profile $profile)
    {
        if (!$profile->allow_upload && $profile->pending_submission) {
            abort(404);
        }

        $request->validate([
            'submission' => 'required|mimes:zip,rar',
        ]);

        $submission = $profile->submissions()->create([
            'step' => Step::first()->status
        ]);

        if ($request->hasFile('submission')) {
            $submission->file()->create([
                'url' => $this->upload(
                    'submission', 
                    $request->file('submission'),
                    autoNamed: false
                ) 
            ]);
        }

        return redirect()->route('competition.index')->with(['success' => 'Berkas Berhasil Diupload.']);
    }

    public function update(Request $request, Profile $profile, Submission $submission)
    {
        if (!$profile->allow_upload && !$profile->pending_submission) {
            abort(404);
        }

        $request->validate([
            'submission' => 'required|mimes:zip,rar',
        ]);

        if ($request->hasFile('submission')) {
            File::updateOrCreate(
                ['fileable_id' => $submission->id, 'fileable_type' => 'App\Models\Submission'],
                ['url' => $this->upload('submission', $request->file('submission'), $submission->file, autoNamed: false) ]
            );
        }

        return redirect()->route('competition.index')->with(['success' => 'Berkas Berhasil Diperbarui.']);
    }
}
