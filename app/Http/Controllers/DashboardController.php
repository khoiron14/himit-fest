<?php

namespace App\Http\Controllers;

use App\Models\Step;
use App\Enums\UserRole;
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
            'step' => 'required|string|in:step_1,step_2,step_3',
        ]);

        Step::first()->update(['status' => $request->step]);

        return redirect()->route('dashboard');
    }
}
