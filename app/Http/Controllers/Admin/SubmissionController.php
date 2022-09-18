<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Enums\CompetitionType;
use App\Enums\StepStatus;
use App\Enums\SubmissionStatus;
use App\Http\Controllers\Controller;
use App\Models\Step;
use App\Models\Submission;

class SubmissionController extends Controller
{
    public function index(CompetitionType $competitionType, StepStatus $stepStatus)
    {
        $submissions = Submission::with('profile', 'file')
            ->whereRelation('profile', 'competition', $competitionType)
            ->where('step', $stepStatus)
            ->get();

        return view('admin.submission.index',compact('submissions'));
    }

    public function pass(Submission $submission)
    {
        if ($submission->step != Step::first()->status) {
            abort(403);
        }

        $submission->update(['status' => SubmissionStatus::Pass]);

        return redirect()->route('admin.submission.index', 
        [$submission->profile->competition, $submission->step]
        )->with(['success' => 'Meloloskan '.$submission->profile->team_name]);
    }

    public function failed(Submission $submission)
    {
        if ($submission->step != Step::first()->status) {
            abort(403);
        }

        $submission->update(['status' => SubmissionStatus::Failed]);

        return redirect()->route('admin.submission.index', 
        [$submission->profile->competition, $submission->step]
        )->with(['success' => 'Tidak meloloskan '.$submission->profile->team_name]);
    }
}
