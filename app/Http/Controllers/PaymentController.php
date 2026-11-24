<?php

namespace App\Http\Controllers;

use App\Models\MembershipTransaction;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with([
            'transaction.application',
            'transaction.member',
        ])->latest()->get();

        return view('admin.payments.index', compact('payments'));
    }

    public function create()
    {
        $transactions = MembershipTransaction::with([
            'application',
            'member',
            'payments',
        ])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('admin.payments.create', compact('transactions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'membership_transaction_id' => [
                'required',
                'exists:membership_transactions,id',
            ],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => [
                'required',
                'in:cash,gcash,bank_transfer,card',
            ],
            'payment_reference' => ['nullable', 'string', 'max:100'],
            'paid_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $payment = DB::transaction(function () use ($validated) {
            $transaction = MembershipTransaction::lockForUpdate()
                ->findOrFail($validated['membership_transaction_id']);

            if ($transaction->status !== 'pending') {
                throw ValidationException::withMessages([
                    'membership_transaction_id' => 'Payments can only be recorded for pending transactions.',
                ]);
            }

            $alreadyPaid = $transaction->payments()->sum('amount');
            $remainingAmount = $transaction->amount - $alreadyPaid;

            if ($validated['amount'] > $remainingAmount) {
                throw ValidationException::withMessages([
                    'amount' => 'The payment cannot be more than the remaining balance of ₱'
                        . number_format($remainingAmount, 2) . '.',
                ]);
            }

            $payment = Payment::create([
                'membership_transaction_id' => $transaction->id,
                'payment_no' => $this->generatePaymentNumber(),
                'amount' => $validated['amount'],
                'payment_method' => $validated['payment_method'],
                'payment_reference' => $validated['payment_reference'] ?? null,
                'paid_at' => $validated['paid_at'],
                'notes' => $validated['notes'] ?? null,
            ]);

            $newPaidAmount = $alreadyPaid + $validated['amount'];

            if ($newPaidAmount >= $transaction->amount) {
                $transaction->update([
                    'status' => 'paid',
                ]);
            }

            return $payment;
        });

        return redirect()
            ->route('admin.payments.index')
            ->with('success', "Payment {$payment->payment_no} was recorded successfully.");
    }

    public function receipt(Payment $payment)
    {
        $payment->load([
            'transaction.application',
            'transaction.member',
        ]);

        return view('admin.payments.receipt', compact('payment'));
    }

    private function generatePaymentNumber(): string
    {
        do {
            $paymentNumber = 'TRL-PAY-' . now()->format('Y') . '-' . Str::upper(Str::random(6));
        } while (Payment::where('payment_no', $paymentNumber)->exists());

        return $paymentNumber;
    }
}