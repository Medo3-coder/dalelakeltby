<?php

namespace App\Models;

class ReservationImage extends BaseModel
{
    const IMAGEPATH = 'reservationimages' ; 

    protected $fillable = ['type','image' , 'reservation_id'];
}
