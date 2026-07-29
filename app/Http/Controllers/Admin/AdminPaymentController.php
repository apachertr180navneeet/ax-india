<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CreatorPayment;

class AdminPaymentController extends Controller
{
    public function index()
    {
        $payments = CreatorPayment::with('user')->latest()->paginate(15);
        $totalPaid = CreatorPayment::where('status', 'completed')->sum('amount');
        $pendingPayouts = CreatorPayment::where('status', 'pending')->sum('amount');

        return view('admin.payments.index', compact('payments', 'totalPaid', 'pendingPayouts'));
    }

    public function process($id)
    {
        $payment = CreatorPayment::findOrFail($id);
        $payment->update([
            'status' => 'completed',
            'paid_at' => now(),
            'transaction_id' => 'TXN_' . strtoupper(uniqid())
        ]);

        return back()->with('success', 'Payout processed successfully.');
    }
}
