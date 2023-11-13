<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Spatie\Translatable\HasTranslations;

class Category extends BaseModel
{
    use HasTranslations,SoftDeletes;

    const IMAGEPATH = 'categories' ; 

    protected $fillable = ['name','parent_id' ,'image' , 'type'];
    public $translatable = ['name'];

    public function scopeMainCategories($query)
    {
        return $query->where('parent_id' , null);
    }
    

    public function childes(){
        return $this->hasMany(self::class,'parent_id')->withTrashed();
    }

    public function parent(){
         return $this->belongsTo(self::class,'parent_id')->withTrashed();
    }


    public function subChildes()
    {
         return $this->childes()->with( 'subChildes' )->withTrashed();
    }

    public function subParents()
    {
        return $this -> parent()->with('subParents')->withTrashed();
    }

    public function getAllChildren ()
    {
        $sections = new Collection();
        foreach ($this->childes as $section) {
            $sections->push($section);
            $sections = $sections->merge($section->getAllChildren());
        }
        return $sections;
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

    public function getFullPath(){
        $parents  = $this->getAllParents () ;
        $current  = Category::where('id',$this->id)->get();
        $parents  = $parents->merge($current);
        $childs   = $this->getAllChildren () ;
        $path     = $childs->merge($parents);
        return $path ;
    }


    public function getImageAttribute()
    {
        if ($this->attributes['image'] && File::exists(public_path('storage/images/' . static::IMAGEPATH . '/' . $this->attributes['image'] ))) {
            $image = $this->getImage($this->attributes['image'], 'categories');
        } else {
            $image = $this->defaultImage('users');
        }
        return $image;
    }


    


}
