<?php

namespace App\Http\Livewire\Admin\Doctor;

use App\Models\Category;
use App\Models\ClinicDate;
use App\Models\ClinicImages;
use App\Models\Clinics;
use App\Models\Country;
use App\Models\Doctor;
use App\Traits\UploadTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class ShowDoctor extends Component {

    use WithFileUploads, UploadTrait;

    public $currentStep = 1;

    public $successMsg = '';

    public $doctor = [];
    public $currentDoctor;

    // ############## step 1 properties
    public $keys;
    public $categories;
    public $image, $identity_image, $name, $nickname, $qualifications, $abstract, $age, $country_code, $phone, $identity_number, $email, $password, $is_blocked, $speciality_id, $category_id, $category;

    // ################### step 3 properties
    public $graduation_certification_image, $graduation_certification_pdf, $practice_certification_image, $practice_certification_pdf, $experience_certification_image, $experience_certification_pdf, $experience_years;

    // ################### step 3 properties
    public $comerical_record, $detection_price, $clinicName, $lat, $lng, $address, $day, $from, $to;
    public $images          = [];
    public $workTimes       = [];
    public $branches        = [];
    public $currentBranches = [];
    public $deletedBranches = [];

    public function mount() { //// used to get data used in the blade
        $this->keys          = Country::get();
        $this->categories    = Category::with('childes')->where(['type' => 'doctor', 'parent_id' => null])->get();
        $this->currentDoctor = Doctor::with('clinics', 'clinics.images', 'clinics.dates')->findOrFail(request()->id);

        $this->name             = $this->currentDoctor->name;
        $this->nickname         = $this->currentDoctor->nickname;
        $this->qualifications   = $this->currentDoctor->qualifications;
        $this->abstract         = $this->currentDoctor->abstract;
        $this->age              = $this->currentDoctor->age;
        $this->country_code     = $this->currentDoctor->country_code;
        $this->phone            = $this->currentDoctor->phone;
        $this->identity_number  = $this->currentDoctor->identity_number;
        $this->email            = $this->currentDoctor->email;
        $this->is_blocked       = $this->currentDoctor->is_blocked;
        $this->category_id      = $this->currentDoctor->category_id;
        $this->category         = $this->categories->find($this->category_id);
        $this->experience_years = $this->currentDoctor->experience_years;

        if (!$this->category) {
            $this->speciality_id = $this->currentDoctor->category_id;
            $this->category      = Category::with('parent')->findOrFail($this->category_id)->parent;
            $this->category_id   = $this->category->id;
        }

        foreach ($this->currentDoctor->clinics as $clinic) {
            $this->currentBranches[] = [
                'id'               => $clinic->id,
                'images'           => [],
                'view_images'      => $clinic->images->pluck('image')->toArray(),
                'lat'              => $clinic->lat,
                'lng'              => $clinic->lng,
                'name'             => $clinic->name,
                'address'          => $clinic->address,
                'detection_price'  => $clinic->detection_price,
                'comerical_record' => $clinic->comerical_record,
                'work_times'       => $clinic->dates,
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

    public function updatedCategoryId() {
        $this->category = $this->categories->find($this->category_id);
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
        if ($file = $this->uploadFile($this->doctor[$key], 'images/' . $directory)) {
            $this->deleteFile($this->currentDoctor->getRawOriginal($key), $directory);
            $this->doctor[$key] = $file;
        }
    }

    public function firstStepSubmit() {
        $rules = [
            'image'           => 'nullable|image',
            'identity_image'  => 'nullable|image',
            'name'            => 'required|max:255',
            'nickname'        => 'nullable|max:255',
            'qualifications'  => 'required',
            'abstract'        => 'required',
            'country_code'    => 'required',
            'phone'           => 'required|min:8|max:11|unique:users,phone',
            'identity_number' => 'required|numeric|min:10',
            'email'           => 'required|unique:users,email',
            'age'             => 'required|numeric|min:24',
            'password'        => 'nullable|min:6',
            'is_blocked'      => 'required',
            'category_id'     => 'required|exists:categories,id',
        ];

        $category = $this->categories->find($this->category_id);
        if ($category && count($category->childes) > 0) {
            $rules['speciality_id'] = 'required|exists:categories,id';
        } else {
            $this->speciality_id = null;
        }

        $this->doctor['firstStep'] = $this->validate($rules);

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
        $this->doctor['secondStep'] = $this->validate($rules);
        $this->currentStep          = 3;
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
            'clinicName'       => 'required',
            'comerical_record' => 'required',
            'detection_price'  => 'required',
            'workTimes'        => 'required|array',
            'workTimes.*.day'  => 'required',
            'workTimes.*.from' => 'required',
            'workTimes.*.to'   => 'required',
            'lat'              => 'required',
            'lng'              => 'required',
            'address'          => 'required',
        ]);

        $this->branches[] = [
            'images'           => $this->images,
            'lat'              => $this->lat,
            'lng'              => $this->lng,
            'name'             => $this->clinicName,
            'address'          => $this->address,
            'comerical_record' => $this->comerical_record,
            'detection_price'  => $this->detection_price,
            'work_times'       => $this->workTimes,
        ];

        $this->lat    = $this->lng    = $this->address    = $this->clinicName    = $this->comerical_record    = $this->detection_price    = null;
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
        $this->lat              = $branch['lat'];
        $this->lng              = $branch['lng'];
        $this->clinicName       = $branch['name'];
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

        if ($this->doctor['firstStep'] && $this->doctor['secondStep']) {
            $this->doctor = array_merge($this->doctor['firstStep'], $this->doctor['secondStep']);
        }

        if ($this->speciality_id !== null) {
            $this->doctor['category_id'] = $this->speciality_id;
        }

        DB::beginTransaction();
        // dd($this->labData);
        try {
            $this->updateFile('image', 'doctors');
            $this->updateFile('identity_image', 'doctors');
            $this->updateFile('graduation_certification_image', 'doctors');
            $this->updateFile('graduation_certification_pdf', 'doctors');
            $this->updateFile('practice_certification_image', 'doctors');
            $this->updateFile('practice_certification_pdf', 'doctors');
            $this->updateFile('experience_certification_image', 'doctors');
            $this->updateFile('experience_certification_pdf', 'doctors');

            $this->currentDoctor->update($this->doctor);

            // add the branches of the lab
            foreach ($this->branches as $branch) {
                $newBranch = Clinics::create($branch + (['doctor_id' => $this->currentDoctor->id]));

                // save work times of the branch
                $branchWorkTimes = [];
                foreach ($branch['work_times'] as $workTime) {
                    $branchWorkTimes[] = [
                        'clinic_id' => $newBranch->id,
                        'day'       => $workTime['day'],
                        'from'      => $workTime['from'],
                        'to'        => $workTime['to'],
                    ];
                }
                ClinicDate::insert($branchWorkTimes);

                // save branch images
                $branchImages = [];
                foreach ($branch['images'] as $branchImage) {
                    $branchImages[] = [
                        'image'     => $this->uploadFile($branchImage, 'images/clinicimages'),
                        'clinic_id' => $newBranch->id,
                    ];
                }
                ClinicImages::insert($branchImages);
            } /// end add branches

            if (count($this->deletedBranches) > 0) {
                $this->currentDoctor->clinics->whereIn('id', $this->deletedBranches)->each(function ($clinic) {
                    $clinic->images->each->delete();
                    $clinic->delete();
                });
            }

            DB::commit();
            return redirect()->route('admin.doctors.all')->with(['success' => __('admin.added_successfully')]);
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }
    }

    public function back($step) {
        $this->currentStep = $step;
    }

    public function render() {
        return view('livewire.admin.doctor.show-doctor');
    }
}
