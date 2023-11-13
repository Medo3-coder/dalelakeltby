<?php

namespace App\Notifications;

use App\Traits\Firebase;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRateProviderNotification extends Notification {
    use Queueable;
    use Firebase;
    private $data;

    public function __construct($url = null) {
        $this->data = [
            'url'       => $url,
            'type'      => 'user_rate_provider_notification',
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
