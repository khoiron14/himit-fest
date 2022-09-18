<?php

namespace App\Http\Controllers;

use App\Enums\StepStatus;
use App\Enums\SubmissionStatus;
use App\Models\Step;
use App\Enums\UserRole;
use App\Models\Profile;
use App\Models\Submission;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->user()->role == UserRole::Admin) {
            $step = Step::first();

            return view('admin.index', compact('step'));
        } elseif (auth()->user()->role == UserRole::Participant) {
            return redirect()->route('profile.index');
        } else {
            abort(403);
        }
    }

    public function changeStep(Request $request)
    {
        $request->validate([
            'step' => 'required|string|in:step_1,step_2,step_3,end',
        ]);

        $this->announce();

        Step::first()->update(['status' => $request->step]);

        return redirect()->route('dashboard');
    }

    public function announce()
    {
        $step = Step::first()->status;

        $submissions = Submission::with('profile')
            ->where('step', $step)
            ->where('status', SubmissionStatus::Pass)
            ->get();

        foreach ($submissions as $submission) {
            $submission->profile->update(['pass_status' => $step]);
        }

        return redirect()->route('dashboard')->with(['success' => 'Berhasil Mengumumkan Peserta Lolos.']);
    }
}
