<?php

namespace App\Listeners;

use App\Events\OrderSaved;
use App\Models\User;
use App\Notifications\OrderNotify;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class OrderSavedListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderSaved $event): void
    {
        Log::info($event->order); //
        foreach (User::where('role', 'admin')->cursor() as $user) {
            $user->notify(new OrderNotify($event->order));
        }
    }
}
