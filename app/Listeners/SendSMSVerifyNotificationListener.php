<?php

namespace App\Listeners;

use App\Notifications\SendSMS;
use Illuminate\Auth\Events\Registered;

class SendSMSVerifyNotificationListener
{

    public function handle(Registered $event): void
    {
        $event->user->notify(new SendSMS($event->code));
    }
}
