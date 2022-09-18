<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PaymentStatus;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('profile', 'file')->get();

        return view('admin.payment.index', compact('payments'));
    }

    public function accept(Payment $payment)
    {
        if ($payment->status != PaymentStatus::Pending) {
            abort(403);
        }

        $payment->update(['status' => PaymentStatus::Accept]);

        return redirect()->route('admin.payment.index')
            ->with(['success' => 'Berhasil menerima pembayaran.']);
    }

    public function reject(Payment $payment)
    {
        if ($payment->status != PaymentStatus::Pending) {
            abort(403);
        }

        $payment->update(['status' => PaymentStatus::Reject]);

        return redirect()->route('admin.payment.index')
            ->with(['success' => 'Berhasil menolak pembayaran.']);
    }
}
