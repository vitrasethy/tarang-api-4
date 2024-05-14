<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\VonageMessage;
use Illuminate\Notifications\Notification;

class SendSMS extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(private readonly int $code)
    {
    }

    public function via(): array
    {
        return ['vonage'];
    }

    public function toVonage(): VonageMessage
    {
        return (new VonageMessage)
            ->content('Your code '.$this->code);
    }
}
