<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReportRate extends BaseModel {
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'report_num',
        'report',
    ];

    public function reservation() {
        return $this->belongsTo(Reservation::class, 'reservation_id');
    }

    public function reportable() {
        return $this->morphTo('reportable');
    }

    public static function boot() {
        parent::boot();
        self::creating(function ($model) {
            $lastId            = self::max('id') ?? 0;
            $model->report_num = date('Y') . ($lastId + 1);
        });
    }
}
