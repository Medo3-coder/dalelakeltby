<?php

namespace App\Http\Livewire\Admin\Lab;

use App\Models\Country;
use App\Models\Lab;
use App\Models\LabBranch;
use App\Models\LabBranchDate;
use App\Models\LabBranchImage;
use App\Models\LabCategory;
use App\Models\SubCategoryLab;
use App\Models\TargetBodyArea;
use App\Traits\UploadTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateLab extends Component {
    use WithFileUploads, UploadTrait;

    public $currentStep = 1;

    public $successMsg = '';

    public $labData = [];

    // ############## step 1 properties
    public $image, $identity_image, $name, $lab_name ,$city_id, $labAddress, $country_code, $phone, $identity_id, $email, $password, $is_blocked;

    public $lab;
    public $keys;
    public $bodyAreas;
    public $categories;
    public $category_ids        = [];
    public $subCategoriesTypes  = [];
    public $subCategoriesPrices = [];

    public $selectedCategories     = [];
    public $selectedTargetedBodies = [];

    // ################### step 2 properties
    public $openImage, $opening_certificate_pdf, $commericalNumber, $lat, $lng, $address, $day, $from, $to;
    public $labImages       = [];
    public $workTimes       = [];
    public $branches        = [];
    public $currentBranches = [];
    public $deletedBranches = [];

    public function mount() { //// used to get data used in the blade
        $this->keys       = Country::get();
        $this->bodyAreas  = TargetBodyArea::get();
        $this->categories = LabCategory::with('children')->where('parent_id', null)->get();

        $this->lab = Lab::with('branches', 'branches.images', 'branches.dates', 'labCategories', 'labSubCategories', 'labSubCategoriesHasMany', 'labSubCategoriesHasMany.labCategory', 'labSubCategoriesHasMany.targetedBodyAreas')->findOrFail(request()->id);

        // first step
        $this->name         = $this->lab->name;
        $this->lab_name     = $this->lab->lab_name;
        $this->labAddress   = $this->lab->address;
        $this->country_code = $this->lab->country_code;
        $this->phone        = $this->lab->phone;
        $this->identity_id  = $this->lab->identity_id;
        $this->email        = $this->lab->email;
        $this->is_blocked   = $this->lab->is_blocked;
        $this->category_ids = $this->lab->labCategories->pluck('id')->toArray();

        // second step
        foreach ($this->lab->branches as $branch) {
            $this->currentBranches[] = [
                'id'                        => $branch->id,
                'images'                    => [],
                'view_images'               => $branch->images->pluck('image')->toArray(),
                'lat'                       => $branch->lat,
                'lng'                       => $branch->lng,
                'address'                   => $branch->address,
                'opening_certificate_image' => $branch->opening_certificate_image,
                'opening_certificate_pdf'   => $branch->opening_certificate_pdf,
                'comerical_record'          => $branch->commericalNumber,
                'work_times'                => $branch->dates,
            ];
        }

        foreach ($this->category_ids as $cat) {
            $this->selectedTargetedBodies[$cat] = [];
        }

        // foreach ($this->category_ids as $category_id) {
        foreach ($this->lab->labSubCategoriesHasMany as $sub_category_pivot) {
            $this->selectedCategories[$sub_category_pivot->labCategory->parent_id][] = [
                'name'            => $sub_category_pivot->labCategory->name,
                'sub_category_id' => $sub_category_pivot->sub_category_id,
                'price'           => $sub_category_pivot->price,
                'targeted_bodies' => $sub_category_pivot->targetedBodyAreas->pluck('id')->toArray(),
            ];

        }
        // }
    }

    protected $listeners = ['changeMap' => 'changeMap'];

    public function changeMap($lat, $lng, $address) {
        $this->lat     = $lat;
        $this->lng     = $lng;
        $this->address = $address;
    }

    public function updating() {
        $this->successMsg = '';
    }

    public function updatedCategoryIds() {
        foreach ($this->categories as $cat) {
            if (!in_array($cat->id, $this->category_ids)) {
                unset($this->selectedCategories[$cat->id]);
            }
        }

        foreach ($this->category_ids as $cat) {
            $this->selectedTargetedBodies[$cat] = [];
        }
    }

    protected function uploadFile($file, $directory) {
        if ($file) {
            $rondomName = time() . '_' . bin2hex(random_bytes(15)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs($directory, $rondomName);
            return $rondomName;
        }
        return null;
    }

    // start category section #####################################################################
    public function saveCategory($category_id) {
        $sub_category = $this->categories->where('id', $category_id)->first();
        $rules        = [
            'subCategoriesTypes.' . $category_id  => 'required|exists:lab_categories,id',
            'subCategoriesPrices.' . $category_id => 'required|numeric|min:1',
        ];
        if ($sub_category->has_targeted_body) {
            $rules['selectedTargetedBodies.' . $category_id] = 'required|array';
        }
        $validatedData                                                                              = $this->validate($rules);
        $this->selectedCategories[$category_id][$validatedData['subCategoriesTypes'][$category_id]] = [
            'name'            => $sub_category->children->where('id', $validatedData['subCategoriesTypes'][$category_id])->first()->name,
            'sub_category_id' => $validatedData['subCategoriesTypes'][$category_id],
            'price'           => $validatedData['subCategoriesPrices'][$category_id],
            'targeted_bodies' => isset($validatedData['selectedTargetedBodies']) ? $validatedData['selectedTargetedBodies'][$category_id] : null,
        ];

        unset($this->subCategoriesTypes[$category_id]);
        unset($this->subCategoriesPrices[$category_id]);
        $this->selectedTargetedBodies[$category_id] = [];
    }

    public function deleteCategory($category_id, $key) {
        unset($this->selectedCategories[$category_id][$key]);
    }

    public function editCategory($category_id, $key) {
        $currentData = $this->selectedCategories[$category_id][$key];

        $this->subCategoriesTypes[$category_id]     = $currentData['sub_category_id'];
        $this->subCategoriesPrices[$category_id]    = $currentData['price'];
        $this->selectedTargetedBodies[$category_id] = $currentData['targeted_bodies'];

        unset($this->selectedCategories[$category_id][$key]);
    }
    // end category section #####################################################################################

    public function firstStepSubmit() {
        $rules = [
            'image'          => 'sometimes|nullable|image',
            'identity_image' => 'sometimes|nullable|image',
            'name'           => 'required|max:255',
            'lab_name'       => 'required|max:255',
            'labAddress'     => 'required|max:255',
            'country_code'   => 'required',
            'phone'          => 'required|min:8|max:11|unique:labs,phone,' . $this->lab->id,
            'identity_id'    => 'required|numeric|min:10',
            'email'          => 'required|unique:labs,email,' . $this->lab->id,
            'password'       => 'sometimes|nullable|min:6',
            'is_blocked'     => 'required',
            'category_ids'   => 'required',
        ];
        $this->labData     = $this->validate($rules);
        $this->currentStep = 2;
    }

    // start branch section ######################################################################################

    // images
    public function deleteBranchImage($index) {
        unset($this->labImages[$index]);
    }

    // end branch section ######################################################################################

    // start times section ######################################################################################

    public function saveTime() {
        $this->validate([
            'day'  => 'required|in:saturday,sunday,monday,tuesday,wednesday,thursday,friday',
            'from' => 'required',
            'to'   => 'required',
        ]);

        $this->workTimes[$this->day] = [
            'day'  => $this->day,
            'from' => $this->from,
            'to'   => $this->to,
        ];

        $this->day  = null;
        $this->from = null;
        $this->to   = null;
    }

    public function deleteWorkingTadime($key) {
        unset($this->workTimes[$key]);
    }
    public function editWorkingTime($key) {
        $this->day  = $this->workTimes[$key]['day'];
        $this->from = $this->workTimes[$key]['from'];
        $this->to   = $this->workTimes[$key]['to'];
        unset($this->workTimes[$key]);
    }

    // end times section ######################################################################################
    public function saveBranch() {
        $this->validate([
            'labImages'               => 'required|array',
            'labImages.*'             => 'image',
            'openImage'               => 'required|image',
            'opening_certificate_pdf' => 'required',
            'commericalNumber'        => 'required',
            'workTimes'               => 'required|array',
            'workTimes.*.day'         => 'required',
            'workTimes.*.from'        => 'required',
            'workTimes.*.to'          => 'required',
            'lat'                     => 'required',
            'lng'                     => 'required',
            'address'                 => 'required',
        ]);

        $this->branches[] = [
            'images'                    => $this->labImages,
            'lat'                       => $this->lat,
            'lng'                       => $this->lng,
            'address'                   => $this->address,
            'opening_certificate_image' => $this->openImage,
            'opening_certificate_pdf'   => $this->opening_certificate_pdf,
            'comerical_record'          => $this->commericalNumber,
            'work_times'                => $this->workTimes,
        ];

        $this->lat       = $this->lng       = $this->address       = $this->openImage       = $this->opening_certificate_pdf       = $this->commericalNumber       = null;
        $this->labImages = $this->workTimes = [];
    }

    public function deleteBranch($index) {
        unset($this->branches[$index]);
    }

    public function deleteCurrentBranch($branch_id) {
        if (count($this->currentBranches) + count($this->branches) > 1) {
            $this->deletedBranches[$branch_id] = $branch_id;
        }
    }
    public function undoDeleteBranch($branch_id) {
        unset($this->deletedBranches[$branch_id]);
    }

    public function editBranch($index) {
        $branch                        = $this->branches[$index];
        $this->lat                     = $branch['lat'];
        $this->lng                     = $branch['lng'];
        $this->address                 = $branch['address'];
        $this->openImage               = $branch['opening_certificate_image'];
        $this->opening_certificate_pdf = $branch['opening_certificate_pdf'];
        $this->commericalNumber        = $branch['comerical_record'];
        $this->labImages               = $branch['images'];
        $this->workTimes               = $branch['work_times'];
        $this->emit('updateMap');
        unset($this->branches[$index]);
    }

    public function storeLab() {
        // $this->validate([
        //     'branches' => 'required|array',
        // ]);

        DB::beginTransaction();
        // dd($this->labData);
        try {
            if ($file = $this->uploadFile($this->labData['image'], 'images/labs')) {
                $this->deleteFile($this->lab->getRawOriginal('image'), 'labs');
                $this->labData['image'] = $file;
            }

            if ($file = $this->uploadFile($this->labData['identity_image'], 'images/labs')) {
                $this->deleteFile($this->lab->getRawOriginal('identity_image'), 'labs');
                $this->labData['identity_image'] = $file;
            }
            $this->lab->update($this->labData);
            $this->lab->labCategories()->detach();
            $this->lab->labCategories()->attach($this->labData['category_ids']);

            // add the sub categories of the lab
            $this->lab->labSubCategoriesHasMany->each->delete();
            foreach ($this->selectedCategories as $lab_category_id => $selectedSubCategories) {
                foreach ($selectedSubCategories as $subcategory) {
                    $labSubCategory = SubCategoryLab::create([
                        'lab_id'          => $this->lab->id,
                        'lab_category_id' => $lab_category_id,
                        'sub_category_id' => $subcategory['sub_category_id'],
                        'price'           => $subcategory['price'],
                    ]);
                    $labSubCategory->targetedBodyAreas()->attach($subcategory['targeted_bodies']);
                }
            } // end add lab categories

            // add the branches of the lab
            foreach ($this->branches as $branch) {
                if ($file = $this->uploadFile($branch['opening_certificate_image'], 'images/labbranch')) {
                    $branch['opening_certificate_image'] = $file;
                }
                if ($file = $this->uploadFile($branch['opening_certificate_pdf'], 'images/labbranch')) {
                    $branch['opening_certificate_pdf'] = $file;
                }
                $newBranch = LabBranch::create($branch + (['lab_id' => $this->lab->id]));

                // save work times of the branch
                $branchWorkTimes = [];
                foreach ($branch['work_times'] as $workTime) {
                    $branchWorkTimes[] = [
                        // 'lab_id'        => $this->lab->id,
                        'lab_branch_id' => $newBranch->id,
                        'day'           => $workTime['day'],
                        'from'          => $workTime['from'],
                        'to'            => $workTime['to'],
                    ];
                }
                LabBranchDate::insert($branchWorkTimes);

                // save branch images
                $branchImages = [];
                foreach ($branch['images'] as $branchImage) {
                    $branchImages[] = [
                        'image'         => $this->uploadFile($branchImage, 'images/labbranch_images'),
                        // 'lab_id'        => $this->lab->id,
                        'lab_branch_id' => $newBranch->id,
                    ];
                }
                LabBranchImage::insert($branchImages);

            } /// end add branches

            if (count($this->deletedBranches) > 0) {
                $this->lab->branches->whereIn('id', $this->deletedBranches)->each(function ($branch) {
                    $branch->images->each->delete();
                    $branch->delete();
                });
            }

            DB::commit();
            return redirect()->route('admin.labs.all')->with(['success' => __('admin.update_successfullay')]);

        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }

    }

    public function back($step) {
        $this->currentStep = $step;
    }

    public function render() {
        return view('livewire.admin.lab.update-lab');
    }
}
