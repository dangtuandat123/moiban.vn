<?php

namespace App\Notifications;

use App\Models\Invitation;
use App\Models\Rsvp;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewRsvpNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Rsvp $rsvp,
        public Invitation $invitation
    ) {}

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toArray($notifiable): array
    {
        $statusText = match($this->rsvp->status) {
            'attending' => 'sẽ tham dự',
            'not_attending' => 'không thể tham dự',
            'maybe' => 'chưa chắc chắn',
            default => $this->rsvp->status
        };

        return [
            'type' => 'rsvp',
            'invitation_id' => $this->invitation->id,
            'invitation_title' => $this->invitation->title,
            'rsvp_id' => $this->rsvp->id,
            'guest_name' => $this->rsvp->guest_name,
            'attendees_count' => $this->rsvp->attendees_count,
            'status' => $this->rsvp->status,
            'message' => "{$this->rsvp->guest_name} ({$this->rsvp->attendees_count} người) {$statusText}",
        ];
    }
}
