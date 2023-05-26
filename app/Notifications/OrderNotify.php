<?php

namespace App\Notifications;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class OrderNotify extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order)
    {
        // the order class

    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $user = User::findOrFail($this->order->user_id)->first();

        return (new MailMessage)
            ->subject("New Chirp from {$user->name}")
            ->greeting("New Chirp from {$user->name}")
            ->line(Str::limit($this->order, 50))
            ->action('Go to Chirper', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [

        ];
    }
}
