<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{
    use HasFactory , HasTranslations;
    protected $fillable = ['name','parent_id'];
    public $translatable = ['name'];

    public function childes(){
        return $this->hasMany(self::class,'parent_id');
    }

    public function parent(){
         return $this->belongsTo(self::class,'parent_id');
    }


    public function subChildes()
    {
         return $this->childes()->with( 'subChildes' );
    }

    public function subParents()
    {
        return $this -> parent()->with('subParents');
    }

    public function getAllParents()
    {
        $parents = collect([]);

        $parent = $this->parent;

        while(!is_null($parent)) {
            $parents->prepend($parent);
            $parent = $parent->parent;
        }
        return $parents;
    }
}
