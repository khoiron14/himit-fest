<?php

namespace App\Http\Controllers\Admin;

use App\Enums\CompetitionType;
use App\Enums\ProfileType;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeamController extends Controller
{
    public function index()
    {
        $profiles = Profile::all();

        return view('admin.team.index', compact('profiles'));
    }

    public function verifCollege(Profile $profile)
    {
        $profile->update([
            'type' => ProfileType::College
        ]);

        return redirect()->route('team.index');
    }

    public function verifGeneral(Profile $profile)
    {
        $profile->update([
            'type' => ProfileType::General,
            'competition' => CompetitionType::UIUX
        ]);

        return redirect()->route('team.index');
    }
}
