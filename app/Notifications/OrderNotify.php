<?php

namespace App\Notifications;

use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class OrderNotify extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public OrderDetail $order)
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
            ->subject("New Order from {$user->email}")
            ->greeting("New Order from {$user->email}")
            ->line("Order No.: {$this->order->order_number}")
            ->action('Order Detail', url('/order/'.$this->order->order_number))
            ->line(':)');
    }

    public function toArray($notifiable)
    {
        return [

        ];
    }
}
