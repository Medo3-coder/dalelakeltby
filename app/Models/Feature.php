<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

class Feature extends Model
{
    use HasFactory , HasTranslations ,SoftDeletes;
    protected $fillable = ['name'];
    public $translatable = ['name'];

    public function properities(){
        return $this->hasMany(Properity::class);
    }

    public function productfeatures(){
        return $this->hasMany(Productfeature::class);
    }
}
