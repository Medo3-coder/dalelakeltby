<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChranicDiseaseUser extends Model
{
    use HasFactory;
    protected $fillable = ['user_id' , 'chranic_disease_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function disease()
    {
        return $this->belongsTo(ChranicDiseases::class)->withTrashed();
    }

}
