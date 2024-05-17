<?php

namespace App\Listeners;

use App\Events\ReservedVenue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendReminderNotification
{
    /**
     * Handle the event.
     */
    public function handle(ReservedVenue $event): void
    {
        //
    }
}
