<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipApplication;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use App\Models\MembershipTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $transactions = MembershipTransaction::with([
            'application',
            'member',
            'payments',
        ])
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->search;

                $query->where(function ($searchQuery) use ($search) {
                    $searchQuery->where('reference_no', 'like', "%{$search}%")
                        ->orWhereHas('application', function ($applicationQuery) use ($search) {
                            $applicationQuery->where('full_name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        })
                        ->orWhereHas('member', function ($memberQuery) use ($search) {
                            $memberQuery->where('first_name', 'like', "%{$search}%")
                                ->orWhere('last_name', 'like', "%{$search}%");
                        });
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->latest()
            ->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $usedApplicationIds = MembershipTransaction::whereNotNull('membership_application_id')
            ->pluck('membership_application_id');

        $applications = MembershipApplication::whereNotIn('id', $usedApplicationIds)
            ->latest()
            ->get();

        $members = Member::where('status', 'Active')
            ->orderBy('first_name')
            ->get();

        return view('admin.transactions.create', compact('applications', 'members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'transaction_type' => ['required', 'in:application,renewal'],

            'membership_application_id' => [
                'nullable',
                'required_if:transaction_type,application',
                'exists:membership_applications,id',
                'unique:membership_transactions,membership_application_id',
            ],

            'member_id' => [
                'nullable',
                'required_if:transaction_type,renewal',
                'exists:members,id',
            ],

            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        $transaction = MembershipTransaction::create([
            'membership_application_id' => $validated['membership_application_id'] ?? null,
            'member_id' => $validated['member_id'] ?? null,
            'reference_no' => $this->generateReferenceNumber(),
            'transaction_type' => $validated['transaction_type'],
            'amount' => $validated['amount'],
            'status' => 'pending',
        ]);

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', "Transaction {$transaction->reference_no} was created successfully.");
    }

    public function approve(MembershipTransaction $transaction)
    {
        if ($transaction->status !== 'paid') {
            return redirect()
                ->route('admin.transactions.index')
                ->with('error', 'Only paid transactions can be approved.');
        }

        DB::transaction(function () use ($transaction) {
            $transaction->refresh();

            $validityMonths = 12;

            if ($transaction->application) {
                $application = $transaction->application;

                $plan = MembershipCategory::find(
                    $application->membership_category_id
                );

                $level = MembershipLevel::where(
                    'name',
                    $plan?->level
                )->first();

                $validityMonths = $level?->validity_months ?? 12;

                $nameParts = preg_split(
                    '/\s+/',
                    trim($application->full_name)
                );

                $firstName = array_shift($nameParts) ?: 'TRAIL';
                $lastName = count($nameParts) ? array_pop($nameParts) : 'Member';
                $middleName = count($nameParts)
                    ? implode(' ', $nameParts)
                    : null;

                $member = Member::firstOrNew([
                    'email' => $application->email,
                ]);

                if (! $member->exists) {
                    $member->fill([
                        'first_name' => $firstName,
                        'middle_name' => $middleName,
                        'last_name' => $lastName,
                        'phone_number' => $application->phone,
                        'address' => $application->address,
                        'membership_category' => $plan?->name ?? 'General',
                        'membership_level' => $plan?->level ?? 'Basic',
                    ]);
                }

                $member->status = 'Active';
                $member->save();

                $application->status = 'approved';
                $application->save();

                $transaction->member_id = $member->id;
            }

            if ($transaction->transaction_type === 'renewal' && $transaction->member) {
                $level = MembershipLevel::where(
                    'name',
                    $transaction->member->membership_level
                )->first();

                $validityMonths = $level?->validity_months ?? 12;

                $transaction->member->status = 'Active';
                $transaction->member->save();
            }

            $transaction->status = 'approved';
            $transaction->approved_at = now();
            $transaction->valid_from = now()->toDateString();
            $transaction->valid_until = now()
                ->addMonths($validityMonths)
                ->toDateString();

            $transaction->save();
        });

        return redirect()
            ->route('admin.transactions.index')
            ->with(
                'success',
                "Transaction {$transaction->reference_no} was approved and the membership is now active."
            );
    }

    public function cancel(MembershipTransaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return redirect()
                ->route('admin.transactions.index')
                ->with('error', 'Only pending transactions can be cancelled.');
        }

        $transaction->update([
            'status' => 'cancelled',
        ]);

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', "Transaction {$transaction->reference_no} was cancelled.");
    }

    public function expire(MembershipTransaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return redirect()
                ->route('admin.transactions.index')
                ->with('error', 'Only pending transactions can be marked as expired.');
        }

        $transaction->update([
            'status' => 'expired',
        ]);

        return redirect()
            ->route('admin.transactions.index')
            ->with('success', "Transaction {$transaction->reference_no} was marked as expired.");
    }

    private function generateReferenceNumber(): string
    {
        do {
            $reference = 'TRL-TXN-' . now()->format('Y')
                . '-' . Str::upper(Str::random(6));
        } while (MembershipTransaction::where('reference_no', $reference)->exists());

        return $reference;
    }
}