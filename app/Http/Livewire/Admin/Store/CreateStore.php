<?php

namespace App\Http\Livewire\Admin\Store;

use App\Models\Country;
use App\Models\Store;
use App\Models\StoreBranch;
use App\Models\StoreBranchImage;
use App\Models\StoreDate;
use Exception;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class CreateStore extends Component {

    use WithFileUploads;

    public $currentStep = 1;

    public $successMsg = '';

    public $store = [];

    // ############## step 1 properties
    public $keys;
    public $image, $identity_image, $name, $age, $country_code, $phone, $identity_number, $email, $password, $is_blocked;

    // ################### step 2 properties
    public $storeName, $comerical_record, $opening_certificate_image, $opening_certificate_pdf, $lat, $lng, $address, $day, $from, $to;
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
            'password'        => 'required|min:6',
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
            'storeName'                 => 'required',
            'comerical_record'          => 'required|min:10',
            'workTimes'                 => 'required|array',
            'workTimes.*.day'           => 'required',
            'workTimes.*.from'          => 'required',
            'workTimes.*.to'            => 'required',
            'lat'                       => 'required',
            'lng'                       => 'required',
            'address'                   => 'required',
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
            'work_times'                => $this->workTimes,
            'opening_certificate_pdf'   => $this->opening_certificate_pdf,
            'opening_certificate_image' => $this->opening_certificate_image,
        ];

        $this->lat    = $this->lng    = $this->address    = $this->comerical_record    = $this->opening_certificate_image    = $this->opening_certificate_pdf    = $this->storeName    = null;
        $this->images = $this->workTimes = [];
    }

    public function deleteBranch($index) {
        unset($this->branches[$index]);
    }

    public function editBranch($index) {
        $branch                          = $this->branches[$index];
        $this->lat                       = $branch['lat'];
        $this->lng                       = $branch['lng'];
        $this->address                   = $branch['address'];
        $this->storeName                 = $branch['name'];
        $this->comerical_record          = $branch['comerical_record'];
        $this->images                    = $branch['images'];
        $this->workTimes                 = $branch['work_times'];
        $this->opening_certificate_image = $branch['opening_certificate_image'];
        $this->opening_certificate_pdf   = $branch['opening_certificate_pdf'];
        $this->emit('updateMap');
        unset($this->branches[$index]);
    }

    public function store() {
        $this->validate([
            'branches' => 'required|array',
        ]);

        DB::beginTransaction();

        try {
            $this->store['image']          = $this->uploadFile($this->store['image'], 'images/stores');
            $this->store['identity_image'] = $this->uploadFile($this->store['identity_image'], 'images/stores');

            $newStore = Store::create($this->store + (['is_active' => 1, 'is_approved' => 'accepted']));

            // add the branches of the lab
            foreach ($this->branches as $branch) {
                $branch['opening_certificate_pdf']   = $this->uploadFile($branch['opening_certificate_pdf'], 'images/storebranch');
                $branch['opening_certificate_image'] = $this->uploadFile($branch['opening_certificate_image'], 'images/storebranch');
                $newBranch                           = StoreBranch::create($branch + (['store_id' => $newStore->id]));

                // save work times of the branch
                $branchWorkTimes = [];
                foreach ($branch['work_times'] as $workTime) {
                    $branchWorkTimes[] = [
                        'store_id'        => $newStore->id,
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
                        'image'           => $this->uploadFile($branchImage, 'images/storebranch'),
                        'store_id'        => $newStore->id,
                        'store_branch_id' => $newBranch->id,
                    ];
                }
                StoreBranchImage::insert($branchImages);

            } /// end add branches

            DB::commit();
            return redirect()->route('admin.stores.all')->with(['success' => __('admin.added_successfully')]);

        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
        }

    }

    public function back($step) {
        $this->currentStep = $step;
    }

    public function render() {
        return view('livewire.admin.store.create-store');
    }
}
