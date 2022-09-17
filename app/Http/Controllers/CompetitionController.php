<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->profile;

        return view('competition.index', compact('profile'));
    }

    public function addCompetition(Request $request, Profile $profile)
    {
        if ($profile->competition != null) {
            return redirect()->back();
        }

        $request->validate([
            'competition' => 'required|in:web_design,bisnis_tik',
        ]);

        $profile->update([
            'competition' => $request->competition
        ]);

        return redirect()->route('competition.index');
    }
}
