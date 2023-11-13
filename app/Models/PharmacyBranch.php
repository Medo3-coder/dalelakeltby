<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UploadTrait;
use App\Traits\SmsTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class PharmacyBranch extends BaseModel
{
    const IMAGEPATH = 'pharmaces' ; 
    use HasFactory , Notifiable, UploadTrait, HasApiTokens, SmsTrait  , SoftDeletes;

    protected $fillable = ['pharmacist_id', 'lat', 'lng', 'address','address_map', 'comerical_record','name'];


    public function pharmacist()
    {
        return $this->belongsTo(Pharmacist::class);
    }

    public function dates()
    {
        return $this->hasMany(PharmacyDate::class);
    }

    
    public function images()
    {
        return $this->hasMany(PharmacyBranchImage::class);
    }
    
}
