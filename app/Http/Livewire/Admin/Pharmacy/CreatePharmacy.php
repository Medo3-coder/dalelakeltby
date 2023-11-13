<?php

namespace App\Http\Livewire\Admin\Pharmacy;

use App\Models\Country;
use App\Models\Pharmacist;
use App\Models\PharmacyBranch;
use App\Models\PharmacyBranchImage;
use App\Models\PharmacyDate;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreatePharmacy extends Component {

    use WithFileUploads;

    public $currentStep = 1;

    public $successMsg = '';

    public $pharmacy = [];

    // ############## step 1 properties
    public $keys;
    public $image, $identity_image, $name, $age, $country_code, $phone, $identity_number, $email, $password, $is_blocked;

    // ################### step 3 properties
    public $graduation_certification_image, $graduation_certification_pdf, $practice_certification_image, $practice_certification_pdf, $experience_certification_image, $experience_certification_pdf, $experience_years;

    // ################### step 3 properties
    public $pharmacyName, $comerical_record, $lat, $lng, $address, $day, $from, $to;
    public $images    = [];
    public $workTimes = [];
    public $branches  = [];

    public function mount() { //// used to get data used in the blade
        $this->keys = Country::get();
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
        $rondomName = time() . '_' . bin2hex(random_bytes(15)) . '.' . $file->getClientOriginalExtension();
        $file->storeAs($directory, $rondomName);
        return $rondomName;
    }

    public function firstStepSubmit() {
        $rules = [
            'image'           => 'required|image',
            'identity_image'  => 'required|image',
            'name'            => 'required|max:255',
            'country_code'    => 'required',
            'phone'           => 'required|min:8|max:11|unique:users,phone',
            'identity_number' => 'required|min:10',
            'email'           => 'required|unique:users,email',
            'age'             => 'required|numeric|min:24',
            'password'        => 'required|min:6',
            'is_blocked'      => 'required',
        ];

        $this->pharmacy['firstStep'] = $this->validate($rules);

        $this->currentStep = 2;
    }

    // start step to qualifications ######################################################################################

    public function secondStepSubmit() {
        $rules = [
            'graduation_certification_image' => 'required|image',
            'graduation_certification_pdf'   => 'required|mimes:pdf',
            'practice_certification_image'   => 'required|image',
            'practice_certification_pdf'     => 'required|mimes:pdf',
            'experience_certification_image' => 'required|image',
            'experience_certification_pdf'   => 'required|mimes:pdf',
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
            'pharmacyName'     => 'required',
            'comerical_record' => 'required',
            'workTimes'        => 'required|array',
            'workTimes.*.day'  => 'required',
            'workTimes.*.from' => 'required',
            'workTimes.*.to'   => 'required',
            'lat'              => 'required',
            'lng'              => 'required',
            'address'          => 'required',
        ]);

        $this->branches[] = [
            'name'             => $this->pharmacyName,
            'images'           => $this->images,
            'lat'              => $this->lat,
            'lng'              => $this->lng,
            'address'          => $this->address,
            'comerical_record' => $this->comerical_record,
            'work_times'       => $this->workTimes,
        ];

        $this->lat    = $this->lng    = $this->address    = $this->comerical_record    = $this->pharmacyName    = null;
        $this->images = $this->workTimes = [];
    }

    public function deleteBranch($index) {
        unset($this->branches[$index]);
    }

    public function editBranch($index) {
        $branch                 = $this->branches[$index];
        $this->lat              = $branch['lat'];
        $this->lng              = $branch['lng'];
        $this->address          = $branch['address'];
        $this->pharmacyName     = $branch['name'];
        $this->comerical_record = $branch['comerical_record'];
        $this->images           = $branch['images'];
        $this->workTimes        = $branch['work_times'];
        $this->emit('updateMap');
        unset($this->branches[$index]);
    }

    public function store() {
        $this->validate([
            'branches' => 'required|array',
        ]);

        if ($this->pharmacy['firstStep'] && $this->pharmacy['secondStep']) {
            $this->pharmacy = array_merge($this->pharmacy['firstStep'], $this->pharmacy['secondStep']);
        }

        DB::beginTransaction();

        try {
            $this->pharmacy['image']                          = $this->uploadFile($this->pharmacy['image'], 'images/pharmacists');
            $this->pharmacy['identity_image']                 = $this->uploadFile($this->pharmacy['identity_image'], 'images/pharmacists');
            $this->pharmacy['graduation_certification_image'] = $this->uploadFile($this->pharmacy['graduation_certification_image'], 'images/pharmacists');
            $this->pharmacy['graduation_certification_pdf']   = $this->uploadFile($this->pharmacy['graduation_certification_pdf'], 'images/pharmacists');
            $this->pharmacy['practice_certification_image']   = $this->uploadFile($this->pharmacy['practice_certification_image'], 'images/pharmacists');
            $this->pharmacy['practice_certification_pdf']     = $this->uploadFile($this->pharmacy['practice_certification_pdf'], 'images/pharmacists');
            $this->pharmacy['experience_certification_image'] = $this->uploadFile($this->pharmacy['experience_certification_image'], 'images/pharmacists');
            $this->pharmacy['experience_certification_pdf']   = $this->uploadFile($this->pharmacy['experience_certification_pdf'], 'images/pharmacists');

            $newPharmacy = Pharmacist::create($this->pharmacy + (['is_active' => 1, 'is_approved' => 'accepted']));

            // add the branches of the lab
            foreach ($this->branches as $branch) {
                $newBranch = PharmacyBranch::create($branch + (['pharmacist_id' => $newPharmacy->id]));

                // save work times of the branch
                $branchWorkTimes = [];
                foreach ($branch['work_times'] as $workTime) {
                    $branchWorkTimes[] = [
                        'pharmacy_branch_id' => $newBranch->id,
                        'day'           => $workTime['day'],
                        'from'          => $workTime['from'],
                        'to'            => $workTime['to'],
                    ];
                }
                PharmacyDate::insert($branchWorkTimes);

                // save branch images
                $branchImages = [];
                foreach ($branch['images'] as $branchImage) {
                    $branchImages[] = [
                        'image'              => $this->uploadFile($branchImage, 'images/pharmacyimages'),
                        'pharmacy_branch_id' => $newBranch->id,
                    ];
                }
                PharmacyBranchImage::insert($branchImages);

            } /// end add branches

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
        return view('livewire.admin.pharmacy.create-pharmacy');
    }
}
