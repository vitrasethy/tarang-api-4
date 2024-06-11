<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class SendReminderSMS extends Notification implements ShouldQueue
{
    use Queueable;

    public function via(): array
    {
        return ['vonage'];
    }

    public function toVonage(): VonageMessage
    {
        return (new VonageMessage)->content('You are 30mn before the game start.');
    }
}
