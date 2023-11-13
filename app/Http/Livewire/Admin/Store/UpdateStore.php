<?php

namespace App\Http\Livewire\Admin\Store;

use App\Models\Country;
use App\Models\Store;
use App\Models\StoreBranch;
use App\Models\StoreBranchImage;
use App\Models\StoreDate;
use App\Traits\UploadTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateStore extends Component {

    use WithFileUploads, UploadTrait;

    public $currentStep = 1;

    public $successMsg = '';

    public $store = [];
    public $currentStore;

    // ############## step 1 properties
    public $keys;
    public $categories;
    public $image, $identity_image, $name, $country_code, $phone, $identity_number, $email, $password, $is_blocked, $speciality_id;

    // ################### step 3 properties
    public $comerical_record, $detection_price, $lat, $lng, $address, $day, $from, $to, $storeName, $opening_certificate_pdf, $opening_certificate_image;
    public $images          = [];
    public $workTimes       = [];
    public $branches        = [];
    public $currentBranches = [];
    public $deletedBranches = [];

    public function mount() { //// used to get data used in the blade
        $this->keys         = Country::get();
        $this->currentStore = Store::with('branches', 'branches.images', 'branches.dates')->findOrFail(request()->id);

        $this->name            = $this->currentStore->name;
        $this->country_code    = $this->currentStore->country_code;
        $this->phone           = $this->currentStore->phone;
        $this->identity_number = $this->currentStore->identity_number;
        $this->email           = $this->currentStore->email;
        $this->is_blocked      = $this->currentStore->is_blocked;

        foreach ($this->currentStore->branches as $branch) {
            $this->currentBranches[] = [
                'id'                        => $branch->id,
                'images'                    => [],
                'view_images'               => $branch->images->pluck('image')->toArray(),
                'lat'                       => $branch->lat,
                'lng'                       => $branch->lng,
                'address'                   => $branch->address,
                'detection_price'           => $branch->detection_price,
                'comerical_record'          => $branch->comerical_record,
                'name'                      => $branch->name,
                'work_times'                => $branch->dates,
                'opening_certificate_image' => $branch->opening_certificate_image,
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
        if ($file = $this->uploadFile($this->store[$key], 'images/' . $directory)) {
            $this->deleteFile($this->currentStore->getRawOriginal($key), $directory);
            $this->store[$key] = $file;
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
            'password'        => 'nullable|min:6',
            'is_blocked'      => 'required',
        ];

        $this->store = $this->validate($rules);

        $this->currentStep = 2;
    }

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
            'images'                    => 'required|array',
            'images.*'                  => 'image',
            'comerical_record'          => 'required|min:10',
            'storeName'                 => 'required',
            'workTimes'                 => 'required|array',
            'workTimes.*.day'           => 'required',
            'workTimes.*.from'          => 'required',
            'workTimes.*.to'            => 'required',
            'lat'                       => 'required',
            'lng'                       => 'required',
            'address'                   => 'required',
            'storeName'                 => 'required',
            'opening_certificate_pdf'   => 'required',
            'opening_certificate_image' => 'required|image',
        ]);

        $this->branches[] = [
            'name'                      => $this->storeName,
            'images'                    => $this->images,
            'lat'                       => $this->lat,
            'lng'                       => $this->lng,
            'address'                   => $this->address,
            'comerical_record'          => $this->comerical_record,
            'detection_price'           => $this->detection_price,
            'work_times'                => $this->workTimes,
            'opening_certificate_pdf'   => $this->opening_certificate_pdf,
            'opening_certificate_image' => $this->opening_certificate_image,
        ];

        $this->lat    = $this->lng    = $this->opening_certificate_pdf    = $this->opening_certificate_image    = $this->address    = $this->comerical_record    = $this->storeName    = null;
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
        $branch                          = $this->branches[$index];
        $this->storeName                 = $branch['name'];
        $this->lat                       = $branch['lat'];
        $this->lng                       = $branch['lng'];
        $this->address                   = $branch['address'];
        $this->comerical_record          = $branch['comerical_record'];
        $this->detection_price           = $branch['detection_price'];
        $this->images                    = $branch['images'];
        $this->workTimes                 = $branch['work_times'];
        $this->opening_certificate_pdf   = $branch['opening_certificate_pdf'];
        $this->opening_certificate_image = $branch['opening_certificate_image'];
        $this->emit('updateMap');
        unset($this->branches[$index]);
    }

    public function store() {
        $this->validate([
            'branches' => 'nullable|array',
        ]);

        if ($this->speciality_id !== null) {
            $this->store['category_id'] = $this->speciality_id;
        }

        DB::beginTransaction();
        // dd($this->labData);
        try {
            $this->updateFile('image', 'stores');
            $this->updateFile('identity_image', 'stores');

            $this->currentStore->update($this->store);

            // add the branches of the lab
            foreach ($this->branches as $branch) {
                $branch['opening_certificate_pdf']   = $this->uploadFile($branch['opening_certificate_pdf'], 'images/storebranch');
                $branch['opening_certificate_image'] = $this->uploadFile($branch['opening_certificate_image'], 'images/storebranch');
                $newBranch                           = StoreBranch::create($branch + (['store_id' => $this->currentStore->id]));

                // save work times of the branch
                $branchWorkTimes = [];
                foreach ($branch['work_times'] as $workTime) {
                    $branchWorkTimes[] = [
                        'store_id'        => $this->currentStore->id,
                        'store_branch_id' => $newBranch->id,
                        'day'             => $workTime['day'],
                        'from'            => $workTime['from'],
                        'to'              => $workTime['to'],
                    ];
                }
                StoreDate::insert($branchWorkTimes);

                // save branch images
                $branchImages = [];
                foreach ($branch['images'] as $branchImage) {
                    $branchImages[] = [
                        'image'           => $this->uploadFile($branchImage, 'images/storeimages'),
                        'store_id'        => $this->currentStore->id,
                        'store_branch_id' => $newBranch->id,
                    ];
                }
                StoreBranchImage::insert($branchImages);

            } /// end add branches

            if (count($this->deletedBranches) > 0) {
                $this->currentStore->branches->whereIn('id', $this->deletedBranches)->each(function ($branch) {
                    $branch->images->each->delete();
                    $branch->delete();
                });
            }

            DB::commit();
            return redirect()->route('admin.stores.all')->with(['success' => __('admin.update_successfullay')]);

        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }

    }

    public function back($step) {
        $this->currentStep = $step;
    }

    public function render() {
        return view('livewire.admin.store.update-store');
    }
}
