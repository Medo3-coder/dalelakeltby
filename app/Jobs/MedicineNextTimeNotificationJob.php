<?php

namespace App\Jobs;

use App\Notifications\MedicineNextTimeNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;


class MedicineNextTimeNotificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $recordMedicine ,$user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($recordMedicine ,$user){
        $this->recordMedicine  = $recordMedicine;
        $this->user            = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(){
        try{
            Notification::send($this->user ,new MedicineNextTimeNotification($this->recordMedicine->reservation_id));
        }catch(\Exception $e){
            info('Medicine Next Time Notification Job error' ,$e);
        }
    }
}
