<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ProductAdditives extends BaseModel
{
    use HasFactory, HasTranslations;
    protected $guarded = [];
    public $translatable = ['name'];
    public function product()
    {

        return $this->belongsTo(Product::class);
    }
}
