<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->profile;

        return view('profile.index', compact('profile'));
    }

    public function store(Request $request)
    {
        $profile = auth()->user()->profile;

        if ($profile) {
            $request->validate([
                'leader_name' => 'required|string|max:255|unique:profiles,leader_name,' . $profile->id,
                'team_name' => 'required|string|max:255|unique:profiles,team_name,' . $profile->id,
                'institution' => 'required|string|max:255',
                'identity' => 'image|mimes:jpg,png,jpeg|max:2048'
            ]);

            $profile->update($request->all());
        } else {
            $request->validate([
                'leader_name' => 'required|string|max:255|unique:profiles,leader_name',
                'team_name' => 'required|string|max:255|unique:profiles,team_name',
                'institution' => 'required|string|max:255',
                'identity' => 'image|mimes:jpg,png,jpeg|max:2048'
            ]);

            $profile = auth()->user()->profile()->create($request->all());
        }

        if ($request->hasFile('identity')) {
            File::updateOrCreate(
                ['fileable_id' => $profile->id, 'fileable_type' => 'App\Models\Profile'],
                ['url' => $this->upload('profile', $request->file('identity'), $profile->identity, autoNamed: false) ]
            );
        }

        return redirect()->route('profile.index')->with(['success' => 'Profile Berhasil Disimpan.']);
    }
}
