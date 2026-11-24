<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMembershipApplicationRequest;
use App\Models\MembershipApplication;
use App\Models\MembershipCategory;
use App\Models\MembershipTransaction;
use App\Notifications\MembershipApplicationSubmitted;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Illuminate\View\View;

class MembershipApplicationController extends Controller
{
    public function create(): View
    {
        return view('membership.create', [
            'categories' => MembershipCategory::query()
                ->where('is_active', true)
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function store(
        StoreMembershipApplicationRequest $request
    ): RedirectResponse {
        $application = DB::transaction(function () use ($request) {
            $validated = $request->validated();

            $category = MembershipCategory::findOrFail(
                $validated['membership_category_id']
            );

            $application = MembershipApplication::create([
                ...$validated,
                'reference_no' => $this->generateApplicationReference(),
            ]);

            MembershipTransaction::create([
                'membership_application_id' => $application->id,
                'reference_no' => $this->generateTransactionReference(),
                'transaction_type' => 'application',
                'amount' => $category->fee,
                'status' => 'pending',
            ]);

            Notification::route('mail', $application->email)
                ->notify(new MembershipApplicationSubmitted($application));

            $application->update([
                'verification_sent_at' => now(),
            ]);

            return $application;
        });

        return redirect()
            ->route('membership.create')
            ->with(
                'success',
                "Application saved. Verification email queued. Reference: {$application->reference_no}"
            );
    }

    private function generateApplicationReference(): string
    {
        do {
            $referenceNumber = 'TRL-APP-' . Str::upper(Str::random(10));
        } while (
            MembershipApplication::where(
                'reference_no',
                $referenceNumber
            )->exists()
        );

        return $referenceNumber;
    }

    private function generateTransactionReference(): string
    {
        do {
            $referenceNumber = 'TRL-TXN-' . now()->format('Y')
                . '-' . Str::upper(Str::random(6));
        } while (
            MembershipTransaction::where(
                'reference_no',
                $referenceNumber
            )->exists()
        );

        return $referenceNumber;
    }
}