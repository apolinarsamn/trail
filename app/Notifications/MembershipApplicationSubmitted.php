<?php

namespace App\Notifications;

use App\Models\MembershipApplication;
use App\Models\MembershipCategory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MembershipApplicationSubmitted extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public MembershipApplication $application
    ) {
        $this->afterCommit();
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $membershipCategory = MembershipCategory::find(
            $this->application->membership_category_id
        );

        return (new MailMessage)
            ->subject('We received your TRAIL membership application')
            ->view('emails.membership-application-submitted', [
                'application' => $this->application,
                'membershipCategory' => $membershipCategory,
            ]);
    }
}