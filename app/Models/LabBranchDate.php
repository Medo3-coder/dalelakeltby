<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LabBranchDate extends Model
{
    use HasFactory;
    protected $fillable = ['lab_id', 'lab_branch_id','day','from','to'];
    
}
