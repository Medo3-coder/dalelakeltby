<?php

namespace App\Models;

class Complaint extends BaseModel {
    protected $fillable = ['name', 'user_id', 'reservation_id', 'complaint'];

    public function user() {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function reservation() {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function replays() {
        return $this->hasMany(ComplaintReplay::class, 'complaint_id', 'id');
    }
}
