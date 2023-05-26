<?php

namespace App\Jobs;

use App\Mail\OrderToAdmin;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Notifications\OrderNotify;
use Mail;

class OrderToAdminJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;

    /**
     * Create a new job instance.
     */
    public function __construct($event)
    {

        $this->event = $event;
    }

   /**
    * Execute the job.
    */
   public function handle()
   {
       $user = User::findOrFail($this->event->order->user_id);
       notify(new OrderNotify($user));
       foreach (['ch.khunanon@gmail.com', $user->email] as $recipient) {
           Mail::to($recipient)->queue(new OrderToAdmin($detail));
       }

   }
}
