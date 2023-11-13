<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\CategoriesResource;
use App\Http\Resources\Api\Settings\ImageResource;
use App\Models\Category;
use App\Models\Image;
use App\Traits\ResponseTrait;


class HomeController extends Controller
{
    use ResponseTrait;

    public function home()
    {
        return $this->successData([
            // only main categories
            'categories'   => CategoriesResource::collection(Category::MainCategories()->get()) , 
            // slider images
            'sliders'      => ImageResource::collection(Image::latest()->get())
        ]);
    }


}
