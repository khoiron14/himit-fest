<?php

namespace App\Http\Controllers;

use App\Enums\StepStatus;
use App\Models\File;
use App\Models\Step;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $profile = auth()->user()->profile;
        $announceMessage = $this->announceMessage();

        return view('profile.index', compact('profile', 'announceMessage'));
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

    public function announceMessage()
    {
        switch (Step::first()->status) {
            case StepStatus::Step2:
                if (auth()->user()->profile->pass_status == StepStatus::Step1) {
                    return [
                        'status' => 'pass',
                        'message' => 'Selamat! Anda lolos Tahap 1. Silahkan lakukan pembayaran jika belum untuk lanjut ke tahap berikutnya.'
                    ];
                } else {
                    return [
                        'status' => 'failed',
                        'message' => 'Mohon maaf anda tidak lolos Tahap 1.'
                    ];
                }
                break;
            case StepStatus::Step3:
                if (auth()->user()->profile->pass_status == StepStatus::Step2) {
                    return [
                        'status' => 'pass',
                        'message' => 'Selamat! Anda lolos Tahap 2.'
                    ];
                } else {
                    return [
                        'status' => 'failed',
                        'message' => 'Mohon maaf anda tidak lolos Tahap 2.'
                    ];
                }
                break;
            case StepStatus::End:
                if (auth()->user()->profile->pass_status == StepStatus::Step3) {
                    return [
                        'status' => 'pass',
                        'message' => 'Selamat! Anda lolos Tahap 3.'
                    ];
                } else {
                    return [
                        'status' => 'failed',
                        'message' => 'Mohon maaf anda tidak lolos Tahap 3.'
                    ];
                }
                break;
        }

        return null;
    }
}
