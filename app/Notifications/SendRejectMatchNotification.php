<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class SendRejectMatchNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct()
    {
    }

    public function via(): array
    {
        return ['vonage'];
    }

    public function toVonage(): VonageMessage
    {
        return (new VonageMessage)
            ->content('Team rejected you.');
    }
}
