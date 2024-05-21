<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class SendReminderSMS extends Notification
{
    use Queueable;

    public function __construct(private readonly string $time)
    {
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['vonage'];
    }

    public function toVonage(): VonageMessage
    {
        return (new VonageMessage)->content('
            This is a friendly reminder that your reservation with us is scheduled
            for one hour from now at ' . $this->time . '.
            We look forward to welcoming you and providing an exceptional experience.
        ');
    }
}
