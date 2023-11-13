<?php

namespace App\Http\Livewire\Admin\Pharmacy;

use App\Models\Country;
use App\Models\Pharmacist;
use App\Models\PharmacyBranch;
use App\Models\PharmacyBranchImage;
use App\Models\PharmacyDate;
use App\Traits\UploadTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdatePharmacy extends Component {

    use WithFileUploads, UploadTrait;

    public $currentStep = 1;

    public $successMsg = '';

    public $pharmacy = [];
    public $currentPharmacy;

    // ############## step 1 properties
    public $keys;
    public $categories;
    public $image, $identity_image, $name, $age, $country_code, $phone, $identity_number, $email, $password, $is_blocked, $speciality_id;

    // ################### step 3 properties
    public $graduation_certification_image, $graduation_certification_pdf, $practice_certification_image, $practice_certification_pdf, $experience_certification_image, $experience_certification_pdf, $experience_years;

    // ################### step 3 properties
    public $comerical_record, $detection_price, $lat, $lng, $address, $day, $from, $to, $pharmacyName;
    public $images          = [];
    public $workTimes       = [];
    public $branches        = [];
    public $currentBranches = [];
    public $deletedBranches = [];

    public function mount() { //// used to get data used in the blade
        $this->keys            = Country::get();
        $this->currentPharmacy = Pharmacist::with('branches', 'branches.images', 'branches.dates')->findOrFail(request()->id);

        $this->name             = $this->currentPharmacy->name;
        $this->age              = $this->currentPharmacy->age;
        $this->country_code     = $this->currentPharmacy->country_code;
        $this->phone            = $this->currentPharmacy->phone;
        $this->identity_number  = $this->currentPharmacy->identity_number;
        $this->email            = $this->currentPharmacy->email;
        $this->is_blocked       = $this->currentPharmacy->is_blocked;
        $this->experience_years = $this->currentPharmacy->experience_years;

        foreach ($this->currentPharmacy->branches as $branch) {
            $this->currentBranches[] = [
                'id'               => $branch->id,
                'images'           => [],
                'view_images'      => $branch->images->pluck('image')->toArray(),
                'lat'              => $branch->lat,
                'lng'              => $branch->lng,
                'address'          => $branch->address,
                'detection_price'  => $branch->detection_price,
                'comerical_record' => $branch->comerical_record,
                'name'             => $branch->name,
                'work_times'       => $branch->dates,
            ];
        }
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

    protected function uploadFile($file, $directory) {
        if ($file) {
            $rondomName = time() . '_' . bin2hex(random_bytes(15)) . '.' . $file->getClientOriginalExtension();
            $file->storeAs($directory, $rondomName);
            return $rondomName;
        }
        return null;
    }

    protected function updateFile($key, $directory) {
        if ($file = $this->uploadFile($this->pharmacy[$key], 'images/' . $directory)) {
            $this->deleteFile($this->currentPharmacy->getRawOriginal($key), $directory);
            $this->pharmacy[$key] = $file;
        }
    }

    public function firstStepSubmit() {
        $rules = [
            'image'           => 'nullable|image',
            'identity_image'  => 'nullable|image',
            'name'            => 'required|max:255',
            'country_code'    => 'required',
            'phone'           => 'required|min:8|max:11|unique:users,phone',
            'identity_number' => 'required|min:10',
            'email'           => 'required|unique:users,email',
            'age'             => 'required|numeric|min:24',
            'password'        => 'nullable|min:6',
            'is_blocked'      => 'required',
        ];

        $this->pharmacy['firstStep'] = $this->validate($rules);

        $this->currentStep = 2;
    }

    // start step to qualifications ######################################################################################

    public function secondStepSubmit() {
        $rules = [
            'graduation_certification_image' => 'nullable|image',
            'graduation_certification_pdf'   => 'nullable|mimes:pdf',
            'practice_certification_image'   => 'nullable|image',
            'practice_certification_pdf'     => 'nullable|mimes:pdf',
            'experience_certification_image' => 'nullable|image',
            'experience_certification_pdf'   => 'nullable|mimes:pdf',
            'experience_years'               => 'required',
        ];
        $this->pharmacy['secondStep'] = $this->validate($rules);
        $this->currentStep            = 3;
    }

    // end step to qualifications ######################################################################################

    // start branch section ######################################################################################

    // images
    public function deleteBranchImage($index) {
        unset($this->images[$index]);
    }

    // end branch section ######################################################################################

    // start times section ######################################################################################

    public function saveTime() {
        $validatedData = $this->validate([
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

    public function deleteWorkingTime($key) {
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
        $validatedData = $this->validate([
            'images'           => 'required|array',
            'images.*'         => 'image',
            'comerical_record' => 'required',
            'pharmacyName'     => 'required',
            'workTimes'        => 'required|array',
            'workTimes.*.day'  => 'required',
            'workTimes.*.from' => 'required',
            'workTimes.*.to'   => 'required',
            'lat'              => 'required',
            'lng'              => 'required',
            'address'          => 'required',
            'pharmacyName'     => 'required',
        ]);

        $this->branches[] = [
            'name'             => $this->pharmacyName,
            'images'           => $this->images,
            'lat'              => $this->lat,
            'lng'              => $this->lng,
            'address'          => $this->address,
            'comerical_record' => $this->comerical_record,
            'detection_price'  => $this->detection_price,
            'work_times'       => $this->workTimes,
        ];

        $this->lat    = $this->lng    = $this->address    = $this->comerical_record    = $this->pharmacyName    = null;
        $this->images = $this->workTimes = [];
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
        $branch                 = $this->branches[$index];
        $this->pharmacyName     = $branch['name'];
        $this->lat              = $branch['lat'];
        $this->lng              = $branch['lng'];
        $this->address          = $branch['address'];
        $this->comerical_record = $branch['comerical_record'];
        $this->detection_price  = $branch['detection_price'];
        $this->images           = $branch['images'];
        $this->workTimes        = $branch['work_times'];
        $this->emit('updateMap');
        unset($this->branches[$index]);
    }

    public function store() {
        $this->validate([
            'branches' => 'nullable|array',
        ]);

        if ($this->pharmacy['firstStep'] && $this->pharmacy['secondStep']) {
            $this->pharmacy = array_merge($this->pharmacy['firstStep'], $this->pharmacy['secondStep']);
        }

        if ($this->speciality_id !== null) {
            $this->pharmacy['category_id'] = $this->speciality_id;
        }

        DB::beginTransaction();
        // dd($this->labData);
        try {
            $this->updateFile('image', 'pharmacists');
            $this->updateFile('identity_image', 'pharmacists');
            $this->updateFile('graduation_certification_image', 'pharmacists');
            $this->updateFile('graduation_certification_pdf', 'pharmacists');
            $this->updateFile('practice_certification_image', 'pharmacists');
            $this->updateFile('practice_certification_pdf', 'pharmacists');
            $this->updateFile('experience_certification_image', 'pharmacists');
            $this->updateFile('experience_certification_pdf', 'pharmacists');

            $this->currentPharmacy->update($this->pharmacy);

            // add the branches of the lab
            foreach ($this->branches as $branch) {
                $newBranch = PharmacyBranch::create($branch + (['pharmacist_id' => $this->currentPharmacy->id]));

                // save work times of the branch
                $branchWorkTimes = [];
                foreach ($branch['work_times'] as $workTime) {
                    $branchWorkTimes[] = [
                        'pharmacist_id'      => $this->currentPharmacy->id,
                        'pharmacy_branch_id' => $newBranch->id,
                        'day'                => $workTime['day'],
                        'from'               => $workTime['from'],
                        'to'                 => $workTime['to'],
                    ];
                }
                PharmacyDate::insert($branchWorkTimes);

                // save branch images
                $branchImages = [];
                foreach ($branch['images'] as $branchImage) {
                    $branchImages[] = [
                        'image'              => $this->uploadFile($branchImage, 'images/pharmacyimages'),
                        'pharmacist_id'      => $this->currentPharmacy->id,
                        'pharmacy_branch_id' => $newBranch->id,
                    ];
                }
                PharmacyBranchImage::insert($branchImages);

            } /// end add branches

            if (count($this->deletedBranches) > 0) {
                $this->currentPharmacy->pharmacyBranch->whereIn('id', $this->deletedBranches)->each(function ($branch) {
                    $branch->images->each->delete();
                    $branch->delete();
                });
            }

            DB::commit();
            return redirect()->route('admin.pharmacies.all')->with(['success' => __('admin.added_successfully')]);

        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }

    }

    public function back($step) {
        $this->currentStep = $step;
    }

    public function render() {
        return view('livewire.admin.pharmacy.update-pharmacy');
    }
}
