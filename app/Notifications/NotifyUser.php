<?php

namespace App\Notifications;

use App\Traits\Firebase;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyUser extends Notification
{
    use Queueable;
    use Firebase;
    private $data;
   
    public function __construct($request)
    {
        $this->data = [
            'body_ar'       => $request['body_ar'],
            'body_kur'      => $request['body_kur'],
            'type'          => 'admin_notify' ,
        ];
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
//        $tokens = [];
//        $types  = [];
//        if(count($notifiable->devices)){
//            foreach ($notifiable->devices as $device) {
//                $tokens[] = $device->device_id ;
//                $types[]  = $device->device_type ;
//            }
//            $this->sendFcmNotification( $tokens ,$types ,$this->MessageData , $notifiable->lang ) ;
//        }

        $this->sendFcmNotification($notifiable->devices(), $this->data, $notifiable->lang);
        return $this->data ;
    }
}
