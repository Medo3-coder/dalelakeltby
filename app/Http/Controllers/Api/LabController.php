<?php

namespace App\Http\Controllers\Api;

use App\Models\Lab;
use App\Models\BloodType;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\BloodTypeResource;
use App\Http\Resources\Api\Lab\LabCollection;
use App\Http\Resources\Api\Lab\LabCategoryDetails;
use App\Http\Resources\Api\Lab\LabDetailsResource;

class LabController extends Controller
{
    use ResponseTrait;


    public function labFilter(Request $request)
    {
        $labs = Lab::filter($request->except(['page']))->paginate(30);
        return $this->successData(new LabCollection($labs));
    }

    public function labDetails($id)
    {
        $lab = Lab::findOrFail($id);
        return $this->successData(new LabDetailsResource($lab));
    }

    public function labCategoryDetails(Request $request)
    {
        $subCategories = Lab::findOrFail($request->lab_id)->labSubCategoriesHasMany->where('lab_category_id' , $request->lab_category_id);
        return $this->successData(LabCategoryDetails::collection($subCategories));
    }
    
    public function addLabReservationsData(Request $request)
    {
        $lab = Lab::findOrFail($request->lab_id);
        $subCategories = $lab->labSubCategoriesHasMany->where('lab_category_id' , $request->lab_category_id);
        return $this->successData([
           'lab'            => new LabDetailsResource($lab) ,
           'sub_categories' =>  LabCategoryDetails::collection($subCategories) , 
           'blood_types'    =>  BloodTypeResource::collection(BloodType::latest()->get())
        ]); 
    }

    
    
}
