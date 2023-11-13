<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderRule extends Model {
    use HasFactory;

    protected $fillable = [
        'permission',
    ];

    // public function permissions() {
    //     return $this->hasMany(ProviderPermission::class, 'provider_rule_id');
    // }

    // public function doctors() {
    //     return $this->belongsToMany(Doctor::class, 'doctor_rules', 'provider_rule_id', 'doctor_id');
    // }

    public function roleable() {
        return $this->morphTo();
    }
}
