<?php

namespace App\Notifications;

use App\Traits\Firebase;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProviderCancelOrderNotification extends Notification {
    use Queueable;
    use Firebase;
    private $data;

    public function __construct($orderNum, $url = null) {
        $this->data = [
            'url'       => $url,
            'type'      => 'provider_cancel_order_notification',
            'order_num' => $orderNum,
        ];
    }

    public function via($notifiable) {
        return ['database'];
    }

    public function toMail($notifiable) {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    public function toArray($notifiable) {
        $this->sendFcmNotification($notifiable->devices(), $this->data, $notifiable->lang);
        return $this->data;
    }
}
