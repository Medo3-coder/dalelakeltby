<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Properity extends BaseModel
{
    use HasFactory, HasTranslations ,SoftDeletes;
    protected $fillable = ['name' , 'feature_id'];
    public $translatable = ['name'];

    public function feature(){
        return $this->belongsTo(Feature::class);
    }

    public function productfeatureproperities(){
        return $this->hasMany(Productfeatureproperity::class);
    }
}
