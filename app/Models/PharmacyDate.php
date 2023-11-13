<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmacyDate extends Model
{
    use HasFactory;
    protected $fillable = ['pharmacy_branch_id','day','from','to'];
}
