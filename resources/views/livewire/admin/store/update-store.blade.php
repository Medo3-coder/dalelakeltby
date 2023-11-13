<div>
    @if (!empty($successMsg))
        <div class="alert alert-success">
            {{ $successMsg }}
        </div>
    @endif
    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="multi-wizard-step">
                <a href="#step-1" type="button" class="btn {{ $currentStep != 1 ? 'btn-default' : 'btn-primary' }}">1</a>
                <p>{{ __('admin.personal_data') }}</p>
            </div>

            <div class="multi-wizard-step">
                <a href="#step-2" type="button" class="btn {{ $currentStep != 2 ? 'btn-default' : 'btn-primary' }}">2</a>
                <p>{{ __('admin.branch_data') }}</p>
            </div>
        </div>
    </div>

    {{--  ######################################################################## start step 1   --}}

    <div class="row setup-content {{ $currentStep != 1 ? 'display-none' : '' }}" id="step-1">
        <div class="row">
            <div class="col-12">
                <div class="row">

                    <div class="imgMontg col-6 text-center">
                        <div class="dropBox">
                            <div class="textCenter">
                                <div wire:ignore class="imagesUploadBlock">
                                    <label class="uploadImg">
                                        <span><i class="feather icon-image"></i></span>
                                        <input type="file" class="imageUploader" accept="image/*" wire:model.defer="image"
                                            name="image">
                                    </label>
                                    @if ($currentStore->image)
                                        <div class="uploadedBlock"><img src="{{ $currentStore->image }}"><button
                                                class="close"><i class="la la-times"></i></button></div>
                                    @endif
                                </div>
                                <div class="col">
                                    <h6 class="bold font14">{{ __('admin.image') }}
                                    </h6>
                                </div>
                                @error('image')
                                    <span style="color: #ff3333">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="imgMontg col-6 text-center">
                        <div class="dropBox">
                            <div class="textCenter">
                                <div wire:ignore class="imagesUploadBlock">
                                    <label class="uploadImg">
                                        <span><i class="feather icon-image"></i></span>
                                        <input type="file" accept="image/*" wire:model.defer="identity_image"
                                            name="image" class="imageUploader">
                                    </label>
                                    @if ($currentStore->identity_image)
                                        <div class="uploadedBlock"><img
                                                src="{{ $currentStore->identity_image }}"><button class="close"><i
                                                    class="la la-times"></i></button></div>
                                    @endif

                                </div>
                                <div class="col">
                                    <h6 class="bold font14">{{ __('admin.identity_image') }}
                                    </h6>
                                </div>
                                @error('identity_image')
                                    <span style="color: #ff3333">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="first-name-column">{{ __('admin.name') }}</label>
                            <div class="controls">
                                <input type="text" wire:model="name" name="name" class="form-control"
                                    placeholder="{{ __('admin.name') }}" required
                                    data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                            </div>
                            @error('name')
                                <span style="color: #ff3333">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="first-name-column">{{ __('admin.email') }}</label>
                            <div class="controls">
                                <input type="email" wire:model="email" class="form-control"
                                    placeholder="{{ __('admin.email') }}" required
                                    data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                            </div>
                            @error('email')
                                <span style="color: #ff3333">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="first-name-column">{{ __('admin.phone') }}</label>
                            <div class="controls">
                                <select style="width: 20% ; position: absolute; left: 3%;" wire:model="country_code"
                                    name="country_code" class="select2 form-control" required
                                    data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                    @foreach ($keys as $key)
                                        <option value="{{ $key->key }}">
                                            {{ $key->key }}</option>
                                    @endforeach
                                </select>
                                <input type="number" minlength="9" maxlength="11" wire:model="phone" name="phone"
                                    class="form-control" placeholder="{{ __('admin.phone') }}" required
                                    data-validation-minlength-message="{{ __('admin.minlength') }}"
                                    data-validation-maxlength-message="{{ __('admin.maxlength') }}"
                                    data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                            </div>
                        </div>
                        @error('phone')
                            <span style="color: #ff3333">{{ $message }}</span> ,
                        @enderror
                        @error('country_code')
                            <span style="color: #ff3333">{{ $message }}</span>
                        @enderror
                    </div>




                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="first-name-column">{{ __('admin.password') }}</label>
                            <div class="controls">
                                <input type="password" wire:model="password" class="form-control"
                                    placeholder="{{ __('admin.password') }}" required
                                    data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                            </div>
                            @error('password')
                                <span style="color: #ff3333">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="first-name-column">{{ __('admin.identity_id') }}</label>
                            <div class="controls">
                                <input type="number" wire:model="identity_number" name="identity_number"
                                    class="form-control" placeholder="{{ __('admin.identity_number') }}" required
                                    data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                            </div>
                            @error('identity_number')
                                <span style="color: #ff3333">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label for="first-name-column">{{ __('admin.ban_status') }}</label>
                            <div class="controls">
                                <select wire:model="is_blocked" name="block" class="select2 form-control" required
                                    data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                    <option value>{{ __('admin.Select_the_blocking_status') }}
                                    </option>
                                    <option value="1">{{ __('admin.Prohibited') }}
                                    </option>
                                    <option value="0">{{ __('admin.Unspoken') }}</option>
                                </select>
                            </div>
                            @error('is_blocked')
                                <span style="color: #ff3333">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                </div>




            </div>
            <div class="row w-100 justify-content-center" wire:loading.remove wire:target="firstStepSubmit">
                <button class="btn mx-1 btn-primary nextBtn btn-lg pull-right" type="button"
                    wire:click="firstStepSubmit">{{ __('admin.next') }}</button>
            </div>
            <div class=" w-100 text-center" wire:loading wire:target="firstStepSubmit">
                <div class="spinner-border text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>

    {{--  ######################################################################## start step 2   --}}
    <div class="row setup-content {{ $currentStep != 2 ? 'display-none' : '' }}" id="step-3">
        <div class="col-12">

            <h5>{{ __('admin.stores') }}</h5>


            @foreach ($currentBranches as $key => $branch)
                <div {{ in_array($branch['id'], $deletedBranches) ? 'style=opacity:.3' : '' }}
                    wire:key="brancheOfId{{ $key }}" class="card  collapse-header">
                    <div id="headingCollapserr{{ $key . 'current' }}" class="card-header pb-2"
                        data-toggle="collapse" role="button" data-target="#collapseww{{ $key . 'current' }}"
                        aria-expanded="false" aria-controls="collapseww{{ $key . 'current' }}">
                        <span class="lead collapse-title">
                            {{ $branch['name'] }}
                        </span>
                        <span wire:loading.remove wire:target="deleteCurrentBranch,undoDeleteBranch">
                            @if (!in_array($branch['id'], $deletedBranches) && count($this->currentBranches) + count($this->branches) > 1)
                                <button wire:click="deleteCurrentBranch({{ $branch['id'] }})" type="button"
                                    class="btn btn-icon btn-icon rounded-circle btn-danger mr-1 waves-effect waves-light"><i
                                        class="feather icon-trash"></i></button>
                            @elseif(in_array($branch['id'], $deletedBranches))
                                <button wire:click="undoDeleteBranch({{ $branch['id'] }})" type="button"
                                    class="btn btn-icon btn-icon rounded-circle btn-warning mr-1 waves-effect waves-light"><i
                                        class="fa fa-undo"></i></button>
                            @endif


                        </span>
                        <span wire:loading wire:target="deleteCurrentBranch,undoDeleteBranch">
                            <div class="spinner-border text-warning" role="deleteWorkingTime">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </span>
                    </div>
                    <div id="collapseww{{ $key . 'current' }}" class="p-2 collapse" role="tabpanel"
                        aria-labelledby="headingCollapserr{{ $key . 'current' }}" class="collapse" style="">

                        <div wire:ignore class="row mt-2">
                            <div class="col-md-3">{{ __('admin.images') }}</div>
                            <div class="col">
                                @foreach ($branch['images'] as $bImageKey => $bImage)
                                    <img src="{{ $bImage->temporaryUrl() }}"
                                        wire:key='bimagekey{{ $key . 'current' . 'aa' . $bImageKey }}' class="m-2"
                                        height="150" alt="">
                                @endforeach
                                @if ($branch['view_images'])
                                    @foreach ($branch['view_images'] as $viewImageKey => $viewImage)
                                        <img src="{{ $viewImage }}"
                                            wire:key='viewimagekey{{ $key . 'current' . 'aa' . $viewImageKey }}'
                                            class="m-2" height="150" alt="">
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        <div wire:ignore class="row mt-2">
                            <div class="col-md-3">{{ __('admin.opening_image') }}</div>
                            <div class="col">
                                @if (is_file($branch['opening_certificate_image']))
                                    <img src="{{ $branch['opening_certificate_image']->temporaryUrl() }}"
                                        class="m-2" height="150" alt="">
                                @elseif($branch['opening_certificate_image'])
                                    <img src="{{ $branch['opening_certificate_image'] }}" class="m-2"
                                        height="150" alt="">
                                @endif
                            </div>
                        </div>


                        <div wire:ignore class="row mt-2">
                            <div class="col-md-3">{{ __('admin.comerical_record') }}</div>
                            <div class="col"> {{ $branch['comerical_record'] }} </div>
                        </div>

                        <div wire:ignore class="row mt-2">
                            <div class="col-md-3">{{ __('admin.address') }}</div>
                            <div class="col"> {{ $branch['address'] }} </div>
                        </div>

                        <div wire:ignore class="row mt-2">
                            <div class="col-md-3">{{ __('admin.working_times') }}</div>
                            <div class="col">
                                @foreach ($branch['work_times'] as $workKey => $workTime)
                                    <div class="row"
                                        wire:key="timesOfBranch{{ $key . 'current' . ' ' . $workKey }}">
                                        <div class="col-md-4">
                                            <div class="mb-2 main-inp-cont">
                                                <h5 class="fontBold mainColor font14">
                                                    {{ __('admin.day') }} :
                                                    {{ __('admin.' . $workTime['day']) }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2 main-inp-cont">
                                                <h5 class="fontBold mainColor font14">
                                                    {{ __('admin.from') }} : {{ $workTime['from'] }}
                                                </h5>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-2 main-inp-cont">
                                                <h5 class="fontBold mainColor font14">
                                                    {{ __('admin.to') }} : {{ $workTime['to'] }}
                                                </h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>


                    </div>
                </div>
            @endforeach


            @if (count($branches))
                <h5 class="mt-2 mb-2">{{ __('admin.new_branches') }}</h5>
            @endif

            @if (count($branches) > 0)
                <div class="mt-2 mb-2">
                    <div class="default-collapse collapse-bordered">

                        @foreach ($branches as $newBranchKey => $branch)
                            <div wire:key="brancheOfId{{ $newBranchKey }}" class="card  collapse-header">
                                <div id="headingCollapserr{{ $newBranchKey }}" class="card-header pb-2"
                                    data-toggle="collapse" role="button"
                                    data-target="#collapseww{{ $newBranchKey }}" aria-expanded="false"
                                    aria-controls="collapseww{{ $newBranchKey }}">
                                    <span class="lead collapse-title">
                                        {{ $branch['name'] }}
                                    </span>
                                    <span wire:loading.remove wire:target="editBranch,deleteBranch">
                                        <button wire:click="deleteBranch({{ $newBranchKey }})" type="button"
                                            class="btn btn-icon btn-icon rounded-circle btn-danger mr-1 waves-effect waves-light"><i
                                                class="feather icon-trash"></i></button>
                                        <button wire:click="editBranch({{ $newBranchKey }})" type="button"
                                            class="btn btn-icon btn-icon rounded-circle btn-success mr-1 waves-effect waves-light"><i
                                                class="feather icon-edit"></i></button>
                                    </span>
                                    <span wire:loading wire:target="editBranch,deleteBranch">
                                        <div class="spinner-border text-warning" role="deleteWorkingTime">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </span>
                                </div>
                                <div id="collapseww{{ $newBranchKey }}" class="p-2 collapse" role="tabpanel"
                                    aria-labelledby="headingCollapserr{{ $newBranchKey }}" class="collapse"
                                    style="">

                                    <div wire:ignore class="row mt-2">
                                        <div class="col-md-3">{{ __('admin.images') }}</div>
                                        <div class="col">
                                            @foreach ($branch['images'] as $bImageKey => $bImage)
                                                <img src="{{ $bImage->temporaryUrl() }}"
                                                    wire:key='bimagekey{{ $newBranchKey . 'aa' . $bImageKey }}'
                                                    class="m-2" height="150" alt="">
                                            @endforeach
                                        </div>
                                    </div>

                                    <div wire:ignore class="row mt-2">
                                        <div class="col-md-3">{{ __('admin.opening_image') }}</div>
                                        <div class="col">
                                            @if ($branch['opening_certificate_image'])
                                                <img src="{{ $branch['opening_certificate_image']->temporaryUrl() }}"
                                                    class="m-2" height="150" alt="">
                                            @endif
                                        </div>
                                    </div>

                                    <div wire:ignore class="row mt-2">
                                        <div class="col-md-3">{{ __('admin.comerical_record') }}</div>
                                        <div class="col"> {{ $branch['comerical_record'] }} </div>
                                    </div>

                                    <div wire:ignore class="row mt-2">
                                        <div class="col-md-3">{{ __('admin.address') }}</div>
                                        <div class="col"> {{ $branch['address'] }} </div>
                                    </div>

                                    <div wire:ignore class="row mt-2">
                                        <div class="col-md-3">{{ __('admin.working_times') }}</div>
                                        <div class="col">
                                            @foreach ($branch['work_times'] as $workKey => $workTime)
                                                <div class="row"
                                                    wire:key="timesOfBranch{{ $newBranchKey . ' ' . $workKey }}">
                                                    <div class="col-md-4">
                                                        <div class="mb-2 main-inp-cont">
                                                            <h5 class="fontBold mainColor font14">
                                                                {{ __('admin.day') }} :
                                                                {{ __('admin.' . $workTime['day']) }}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2 main-inp-cont">
                                                            <h5 class="fontBold mainColor font14">
                                                                {{ __('admin.from') }} : {{ $workTime['from'] }}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="mb-2 main-inp-cont">
                                                            <h5 class="fontBold mainColor font14">
                                                                {{ __('admin.to') }} : {{ $workTime['to'] }}
                                                            </h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>


                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            @endif

            <h5 class="text-center p-3">
                {{ __('admin.new_branch') }}
            </h5>

            <div class="imgMontg col-12 mt-2">

                <div class="p-0 col-12">
                    <div class="form-group">
                        <div class="controls">
                            <label for="account-name">{{ __('admin.images') }}</label>
                            <input accept="image/*" multiple wire:model.defer="images" type="file"
                                class="form-control" name="images" placeholder="{{ __('admin.images') }}">
                        </div>

                        <div>
                            @foreach ($images as $key => $image)
                                <span wire:click="deleteBranchImage({{ $key }})"
                                    class="branch_images_image"> <i class="fa fa-trash"></i> <img height="100"
                                        src="{{ $image->temporaryUrl() }}"></span>
                            @endforeach
                        </div>
                    </div>
                    @error('images')
                        <span style="color: #ff3333">{{ $message }}</span>
                    @enderror
                </div>

            </div>
        </div>



        <div class="col-md-6 col-12">
            <div class="form-group">
                <div class="controls">
                    <label for="account-name">{{ __('admin.opening_certificate_image') }}</label>
                    <input accept="image/*" type="file" wire:model.defer="opening_certificate_image" class="form-control"
                        name="opening_certificate_image" placeholder="{{ __('admin.opening_certificate_image') }}">
                </div>
                @if ($opening_certificate_image)
                    <img height="100" src="{{ $opening_certificate_image->temporaryUrl() }}">
                @endif
            </div>
            @error('opening_certificate_image')
                <span style="color: #ff3333">{{ $message }}</span>
            @enderror
        </div>




        <div class="col-md-6 col-12">
            <div class="form-group">
                <div class="controls">
                    <label for="account-name">{{ __('admin.opening_certificate_pdf') }}</label>
                    <input wire:model.defer="opening_certificate_pdf" type="file" class="form-control"
                        name="opening_certificate_pdf" placeholder="{{ __('admin.opening_certificate_pdf') }}">
                </div>
                @error('opening_certificate_pdf')
                    <span style="color: #ff3333">{{ $message }}</span>
                @enderror
            </div>
        </div>




        <div class="col-6">
            <div class="form-group">
                <label for="first-name-column">{{ __('admin.comerical_record') }}</label>
                <div class="controls">
                    <input wire:model="comerical_record" type="number" name="comerical_record" class="form-control"
                        placeholder="{{ __('admin.comerical_record') }}"
                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                </div>
                @error('comerical_record')
                    <span style="color: #ff3333">{{ $message }}</span>
                @enderror
            </div>
        </div>


        <div class="col-6">
            <div class="form-group">
                <label for="first-name-column">{{ __('admin.name') }}</label>
                <div class="controls">
                    <input wire:model="storeName" type="text" name="name" class="form-control"
                        placeholder="{{ __('admin.name') }}"
                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                </div>
                @error('name')
                    <span style="color: #ff3333">{{ $message }}</span>
                @enderror
            </div>
        </div>


        {{--  working times  --}}
        <div class=" m-auto round10 col-12 pl-4 pr-4 form-cont">
            <div class="">
                <h6 class="bold farouk">
                    {{ __('admin.timings') }}</h6>


                @if (count($workTimes) > 0)
                    <div class="mt-2 mb-2">
                        <div class="default-collapse collapse-bordered">

                            @foreach ($workTimes as $key => $workTime)
                                <div class="card  collapse-header">
                                    <div id="headingCollapserr{{ $key }}" class="card-header "
                                        data-toggle="collapse" role="button"
                                        data-target="#collapseww{{ $key }}" aria-expanded="false"
                                        aria-controls="collapseww{{ $key }}">
                                        <span class="lead collapse-title">
                                            {{ __('admin.' . $workTime['day']) }}
                                        </span>
                                        <span wire:loading.remove wire:target="editWorkingTime,deleteWorkingTime">
                                            <button wire:click="deleteWorkingTime('{{ $key }}')"
                                                type="button"
                                                class="btn btn-icon btn-icon rounded-circle btn-danger mr-1 waves-effect waves-light"><i
                                                    class="feather icon-trash"></i></button>
                                            <button wire:click="editWorkingTime('{{ $key }}')"
                                                type="button"
                                                class="btn btn-icon btn-icon rounded-circle btn-success mr-1 waves-effect waves-light"><i
                                                    class="feather icon-edit"></i></button>
                                        </span>
                                        <span wire:loading wire:target="editWorkingTime,deleteWorkingTime">
                                            <div class="spinner-border text-warning" role="deleteWorkingTime">
                                                <span class="sr-only">Loading...</span>
                                            </div>
                                        </span>
                                    </div>
                                    <div id="collapseww{{ $key }}" class="p-2 collapse" role="tabpanel"
                                        aria-labelledby="headingCollapserr{{ $key }}" class="collapse"
                                        style="">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="mb-2 main-inp-cont">
                                                    <h5 class="fontBold mainColor font14">
                                                        {{ __('admin.day') }} :
                                                        {{ __('admin.' . $workTime['day']) }}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2 main-inp-cont">
                                                    <h5 class="fontBold mainColor font14">
                                                        {{ __('admin.from') }} : {{ $workTime['from'] }}
                                                    </h5>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-2 main-inp-cont">
                                                    <h5 class="fontBold mainColor font14">
                                                        {{ __('admin.to') }} : {{ $workTime['to'] }}
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                @endif

                <div class="time-slider-cont ">

                    <div class=" w-100 time-cont pt-3">

                        <div class="times-cont" id="clone_div">
                            <div class="container time m-auto">
                                <div class="row align-items-center">
                                    <div class="col-md  p-1">
                                        <label class="bold">{{ __('admin.day') }}
                                        </label>


                                        <select wire:model="day" id=""
                                            class="form-control border no-arrow days_select days_select_each">
                                            <option selected value=>{{ __('admin.select_day') }}</option>
                                            <option value="saturday">
                                                {{ __('admin.saturday') }}</option>
                                            <option value="sunday">
                                                {{ __('admin.sunday') }}</option>
                                            <option value="monday">
                                                {{ __('admin.monday') }}</option>
                                            <option value="tuesday">
                                                {{ __('admin.tuesday') }}</option>
                                            <option value="wednesday">
                                                {{ __('admin.wednesday') }}
                                            </option>
                                            <option value="thursday">
                                                {{ __('admin.thursday') }}
                                            </option>
                                            <option value="friday">
                                                {{ __('admin.friday') }}</option>
                                        </select>

                                        @error('day')
                                            <span style="color: #ff3333">{{ $message }}</span>
                                        @enderror

                                    </div>

                                    <div class="col-md  p-1 ">
                                        <label class="bold">{{ __('admin.from') }}
                                        </label>
                                        <input type="time" class="form-control  border round5 w-100"
                                            wire:model="from" id="">
                                        @error('from')
                                            <span style="color: #ff3333">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md  p-1">
                                        <label class="bold">{{ __('admin.to') }}</label>
                                        <input type="time" class="form-control  border round5 w-100"
                                            wire:model="to" id="">
                                        @error('to')
                                            <span style="color: #ff3333">{{ $message }}</span>
                                        @enderror
                                    </div>




                                    {{--  <div class="col-md-1  p-1">
                                        <div class="d-flex align-items-center flex-column">
                                            <label class="bold sn" style="color: #fff;"></label>
                                            <a type="button" class="button-error material-button"
                                                onclick="removeTime(this)"><i class="fa fa-times"></i></a>
                                        </div>
                                    </div>  --}}

                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                @error('workTimes')
                    <span style="color: #ff3333">{{ $message }}</span>
                @enderror

            </div>
            <a wire:click="saveTime" wire:loading.remove wire:target="saveTime"
                class="m-3 btn btn-primary add-time float-left">
                {{ __('admin.save') }}</a>
            <div class=" w-100 " wire:loading wire:target="saveTime">
                <div class="spinner-border text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>

        <div wire:ignore class="col-12 p-2">
            <div class="form-group map_container">
                <input wire:model="address" name="address" id="address" class="form-control address"
                    placeholder="{{ __('admin.address') }}" required
                    data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                <div id="map" class="map" style="width: 100%;height:250px;">
                </div>
                <input wire:model="lat" type="hidden" class="lat" value="30.333" name="lat"
                    id="lat">
                <input wire:model="lng" type="hidden" class="lng" value="30.333" name="lng"
                    id="lng">
            </div>
        </div>

        @error('branches')
            <span style="color: #ff3333">{{ $message }}</span>
        @enderror



        <div class="p-3 col-12">
            <div class="row w-100 justify-content-center" wire:loading.remove wire:target="saveBranch">
                <button class="btn mx-1 btn-success nextBtn btn-lg pull-right" type="button"
                    wire:click="saveBranch">{{ __('admin.save_branch') }} <i class="fa mE-1 fa-plus"></i></button>
            </div>
            <div class=" w-100 text-center" wire:loading wire:target="saveBranch">
                <div class="spinner-border text-warning" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

        </div>


        <div class="row w-100 justify-content-center" wire:loading.remove wire:target="store,back">
            <button class="btn mx-1 btn-success nextBtn btn-lg pull-right" type="button"
                wire:click="store">{{ __('admin.update') }}</button>
            <button class="btn mx-1 btn-danger nextBtn btn-lg pull-right" type="button"
                wire:click="back(1)">{{ __('admin.back') }}</button>
        </div>

        <div class=" w-100 text-center" wire:loading wire:target="store,back">
            <div class="spinner-border text-warning" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

    </div>
    {{--  ######################################################################## end step 2   --}}

    {{--  <div class="row setup-content {{ $currentStep != 3 ? 'display-none' : '' }}" id="step-3">
        <div class="col-md-12">
            <h3> Step 3</h3>

            <button class="btn btn-success btn-lg pull-right" wire:click="submitForm" type="button">Finish!</button>
            <button class="btn btn-danger nextBtn btn-lg pull-right" type="button"
                wire:click="back(2)">Back</button>
        </div>
    </div>  --}}


</div>
