<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UploadTrait;

class PharmacyBranchImage extends BaseModel
{
    const IMAGEPATH = 'pharmacyimages' ; 
    use HasFactory ;
    protected $fillable = ['image','pharmacy_branch_id'];
}
