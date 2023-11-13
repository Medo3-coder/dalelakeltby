<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProviderPermission extends Model {
    use HasFactory;

    protected $fillable = [
        'provider_rule_id',
        'permission',
    ];

    public function rule() {
        return $this->belongsTo(ProviderRule::class, 'provider_rule_id');
    }
}
