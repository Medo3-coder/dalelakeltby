<?php

namespace App\Notifications;

use App\Traits\Firebase;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DoctorRefuseOrderNotification extends Notification {
    use Queueable;
    use Firebase;
    private $data;

    public function __construct($reservation_id) {
        $this->data = [
            'reservation_id'    => (int)$reservation_id,
            'type'              => 'patient_refuse_order_notification',
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
        return $this->data ;
    }
}
