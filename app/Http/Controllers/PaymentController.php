<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Enums\StepStatus;
use App\Models\Submission;
use App\Enums\PaymentStatus;
use Illuminate\Http\Request;
use App\Enums\SubmissionStatus;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $sub1 = Submission::where('profile_id', auth()->user()->profile->id)->where('step', StepStatus::Step1)->first();
        if (!($sub1 && ($sub1?->status == SubmissionStatus::Pass))) {
            abort(403);
        }

        $payment = auth()->user()->profile->payment;

        return view('payment.index', compact('payment'));
    }

    public function store(Request $request)
    {
        $sub1 = Submission::where('profile_id', auth()->user()->profile->id)->where('step', StepStatus::Step1)->first();
        $payment = auth()->user()->payment;
        if (!($sub1 && ($sub1?->status == SubmissionStatus::Pass))) {
            if ($payment && ($payment->status != PaymentStatus::Pending)) {
                abort(403);
            }
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'image|mimes:jpg,png,jpeg',
        ]);

        $payment = Payment::updateOrCreate(
            ['profile_id' => auth()->user()->profile->id],
            ['name' => $request->name ]
        );

        if ($request->hasFile('file')) {
            File::updateOrCreate(
                ['fileable_id' => $payment->id, 'fileable_type' => 'App\Models\Payment'],
                ['url' => $this->upload('payment', $request->file('file'), $payment->file, autoNamed: false) ]
            );
        }

        return redirect()->route('payment.index')->with(['success' => 'Berhasil upload bukti pembayaran.']);
    }
}
