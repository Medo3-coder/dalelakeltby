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
                <p>{{ __('admin.qualifications') }}</p>
            </div>
            <div class="multi-wizard-step">
                <a href="#step-2" type="button"
                   class="btn {{ $currentStep != 3 ? 'btn-default' : 'btn-primary' }}">3</a>
                <p>{{ __('admin.clinic_data') }}</p>
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
                                        <input type="file" class="imageUploader" accept="image/*" wire:model="image"
                                               name="image">
                                    </label>
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
                                        <input type="file" accept="image/*" wire:model="identity_image"
                                               name="image" class="imageUploader">
                                    </label>

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
                            <label
                                    for="first-name-column">{{ __('admin.nickname') . ' ' . __('admin.not_required') }}</label>
                            <div class="controls">
                                <input type="text" wire:model="nickname" class="form-control"
                                       placeholder="{{ __('admin.nickname') }}" required
                                       data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                            </div>
                            @error('nickname')
                            <span style="color: #ff3333">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label for="first-name-column">{{ __('admin.city') }}</label>
                            <div class="controls">
                                <select wire:model="city_id" name="block" class="select2 form-control" required
                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                    <option disabled selected>{{ __('admin.select') . ' ' . __('admin.city') }}
                                    </option>
                                    @foreach ($cities as $city_key => $city)
                                        <option wire:key="city-key-{{ $city_key }}" value="{{ $city->id }}">
                                            {{ $city->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('city_id')
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
                            <div class="controls">
                                <label for="account-name">{{ __('admin.qualifications') }}</label>
                                <textarea wire:model="qualifications" class="form-control" cols="30" rows="10"
                                          placeholder="{{ __('admin.qualifications') }}"></textarea>
                            </div>
                            @error('qualifications')
                            <span style="color: #ff3333">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <div class="controls">
                                <label for="account-name">{{ __('admin.abstract') }}</label>
                                <textarea wire:model="abstract" class="form-control" cols="30" rows="10"
                                          placeholder="{{ __('admin.abstract') }}"></textarea>
                            </div>
                            @error('abstract')
                            <span style="color: #ff3333">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-6 col-12">
                        <div class="form-group">
                            <label for="first-name-column">{{ __('admin.phone') }}</label>
                            <div class="controls">
                                <select style="width: 30% ; position: absolute; left: 3%;" wire:model="country_code"
                                        name="country_code" class="select2 form-control" required
                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                    <option value=>{{ __('admin.choose') }} {{ __('admin.country_code') }}</option>
                                    @foreach ($keys as $VV => $key)
                                        <option value="{{ $key->key }}">{{ $key->key }}</option>
                                    @endforeach
                                </select>
                                <input type="number" minlength="9" maxlength="11" wire:model="phone"
                                       name="phone" class="form-control" placeholder="{{ __('admin.phone') }}"
                                       required data-validation-minlength-message="{{ __('admin.minlength') }}"
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
                            <label for="first-name-column">{{ __('admin.age') }}</label>
                            <div class="controls">
                                <input type="number" wire:model="age" class="form-control"
                                       placeholder="{{ __('admin.age') }}" required
                                       data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                            </div>
                            @error('age')
                            <span style="color: #ff3333">{{ $message }}</span>
                            @enderror
                        </div>
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

                    <div class="col-md-6 col-6">
                        <div class="form-group">
                            <label for="first-name-column">{{ __('admin.speciality') }}</label>
                            <div class="controls">
                                <select wire:model="category_id" name="block" class="select2 form-control" required
                                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                    <option disabled selected>{{ __('admin.select') . ' ' . __('admin.speciality') }}
                                    </option>
                                    @foreach ($categories as $categoryKey => $cat)
                                        <option wire:key="mainCategory{{ $categoryKey }}"
                                                value="{{ $cat->id }}">{{ $cat->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('category_id')
                            <span style="color: #ff3333">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    @php
                        $category = $categories->find($category_id);
                    @endphp
                    @if ($category_id && $category && count($category->childes) > 0)
                        <div class="col-md-6 col-6">
                            <div class="form-group">
                                <label for="first-name-column">{{ __('admin.sub_speciality') }}</label>
                                <div class="controls">
                                    <select wire:model="speciality_id"  class="select2 form-control"
                                            required
                                            data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                        <option selected>
                                            {{ __('admin.select') . ' ' . __('admin.sub_speciality') }}
                                        </option>
                                        @foreach ($categories->find($category_id)->childes as $categoryKey => $child)
                                            <option wire:key="subCategory{{ $categoryKey }}"
                                                    value="{{ $child->id }}">{{ $child->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('speciality_id')
                                <span style="color: #ff3333">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    @endif

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
    <div class="row setup-content {{ $currentStep != 2 ? 'display-none' : '' }}" id="step-2">
        <div class="col-12">

            <h5>{{ __('admin.qualifications') }}</h5>

        </div>



        <div class="col-md-6 col-12">
            <div class="form-group">
                <div class="controls">
                    <label for="account-name">{{ __('admin.graduation_certification_image') }}</label>
                    <input accept="image/*" type="file" wire:model.defer="graduation_certification_image"
                           class="form-control" placeholder="{{ __('admin.graduation_certification_image') }}">
                </div>
                @if ($graduation_certification_image)
                    <img height="100" src="{{ $graduation_certification_image->temporaryUrl() }}">
                @endif
            </div>
            @error('graduation_certification_image')
            <span style="color: #ff3333">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6 col-12">
            <div class="form-group">
                <div class="controls">
                    <label for="account-name">{{ __('admin.graduation_certification_pdf') }}</label>
                    <input wire:model.defer="graduation_certification_pdf" accept="application/pdf" type="file"
                           class="form-control" placeholder="{{ __('admin.opening_certificate_pdf') }}">
                </div>
                @error('graduation_certification_pdf')
                <span style="color: #ff3333">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="form-group">
                <div class="controls">
                    <label for="account-name">{{ __('admin.practice_certification_image') }}</label>
                    <input accept="image/*" type="file" wire:model.defer="practice_certification_image"
                           class="form-control" placeholder="{{ __('admin.practice_certification_image') }}">
                </div>
                @if ($practice_certification_image)
                    <img height="100" src="{{ $practice_certification_image->temporaryUrl() }}">
                @endif
            </div>
            @error('practice_certification_image')
            <span style="color: #ff3333">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6 col-12">
            <div class="form-group">
                <div class="controls">
                    <label for="account-name">{{ __('admin.practice_certification_pdf') }}</label>
                    <input wire:model.defer="practice_certification_pdf" accept="application/pdf" type="file"
                           class="form-control" placeholder="{{ __('admin.opening_certificate_pdf') }}">
                </div>
                @error('practice_certification_pdf')
                <span style="color: #ff3333">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="form-group">
                <div class="controls">
                    <label for="account-name">{{ __('admin.experience_certification_image') }}</label>
                    <input accept="image/*" type="file" wire:model.defer="experience_certification_image"
                           class="form-control" placeholder="{{ __('admin.experience_certification_image') }}">
                </div>
                @if ($experience_certification_image)
                    <img height="100" src="{{ $experience_certification_image->temporaryUrl() }}">
                @endif
            </div>
            @error('experience_certification_image')
            <span style="color: #ff3333">{{ $message }}</span>
            @enderror
        </div>

        <div class="col-md-6 col-12">
            <div class="form-group">
                <div class="controls">
                    <label for="account-name">{{ __('admin.experience_certification_pdf') }}</label>
                    <input wire:model.defer="experience_certification_pdf" accept="application/pdf" type="file"
                           class="form-control" placeholder="{{ __('admin.opening_certificate_pdf') }}">
                </div>
                @error('experience_certification_pdf')
                <span style="color: #ff3333">{{ $message }}</span>
                @enderror
            </div>
        </div>


        <div class="col-12">
            <div class="form-group">
                <label for="first-name-column">{{ __('admin.experience_years') }}</label>
                <div class="controls">
                    <input wire:model="experience_years" type="number" name="experience_years" class="form-control"
                           placeholder="{{ __('admin.experience_years') }}"
                           data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                </div>
                @error('experience_years')
                <span style="color: #ff3333">{{ $message }}</span>
                @enderror
            </div>
        </div>


        <div class="row w-100 justify-content-center" wire:loading.remove wire:target="secondStepSubmit">
            <button class="btn mx-1 btn-primary nextBtn btn-lg pull-right" type="button"
                    wire:click="secondStepSubmit">{{ __('admin.next') }}</button>
            <button class="btn mx-1 btn-danger nextBtn btn-lg pull-right" type="button"
                    wire:click="back(1)">{{ __('admin.back') }}</button>
        </div>

        <div class=" w-100 text-center" wire:loading wire:target="secondStepSubmit">
            <div class="spinner-border text-warning" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

    </div>
    {{--  ######################################################################## end step 2   --}}

    {{--  ######################################################################## start step 3   --}}
    <div class="row setup-content {{ $currentStep != 3 ? 'display-none' : '' }}" id="step-3">
        <div class="col-12">

            <h5>{{ __('admin.clinics') }}</h5>

            @if (count($branches) > 0)
                <div class="mt-2 mb-2">
                    <div class="default-collapse collapse-bordered">

                        @foreach ($branches as $key => $branch)
                            <div wire:key="brancheOfId{{ $key }}" class="card  collapse-header">
                                <div id="headingCollapserr{{ $key }}" class="card-header "
                                     data-toggle="collapse" role="button"
                                     data-target="#collapseww{{ $key }}" aria-expanded="false"
                                     aria-controls="collapseww{{ $key }}">
                                    <span class="lead collapse-title">
                                        {{ $branch['name'] }}
                                    </span>
                                    <span wire:loading.remove wire:target="editBranch,deleteBranch">
                                        <button wire:click="deleteBranch({{ $key }})" type="button"
                                                class="btn btn-icon btn-icon rounded-circle btn-danger mr-1 waves-effect waves-light"><i
                                                    class="feather icon-trash"></i></button>
                                        <button wire:click="editBranch({{ $key }})" type="button"
                                                class="btn btn-icon btn-icon rounded-circle btn-success mr-1 waves-effect waves-light"><i
                                                    class="feather icon-edit"></i></button>
                                    </span>
                                    <span wire:loading wire:target="editBranch,deleteBranch">
                                        <div class="spinner-border text-warning" role="deleteWorkingTime">
                                            <span class="sr-only">Loading...</span>
                                        </div>
                                    </span>
                                </div>
                                <div id="collapseww{{ $key }}" class="p-2 collapse" role="tabpanel"
                                     aria-labelledby="headingCollapserr{{ $key }}" class="collapse"
                                     style="">

                                    <div wire:ignore class="row mt-2">
                                        <div class="col-md-3">{{ __('admin.images') }}</div>
                                        <div class="col">
                                            @foreach ($branch['images'] as $bImageKey => $bImage)
                                                <img src="{{ $bImage->temporaryUrl() }}"
                                                     wire:key='bimagekey{{ $key . 'aa' . $bImageKey }}'
                                                     class="m-2" height="150" alt="">
                                            @endforeach
                                        </div>
                                    </div>



                                    <div wire:ignore class="row mt-2">
                                        <div class="col-md-3">{{ __('admin.comerical_record') }}</div>
                                        <div class="col"> {{ $branch['comerical_record'] }} </div>
                                    </div>

                                    <div wire:ignore class="row mt-2">
                                        <div class="col-md-3">{{ __('admin.detection_price') }}</div>
                                        <div class="col"> {{ $branch['detection_price'] }} </div>
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
                                                     wire:key="timesOfBranch{{ $key . ' ' . $workKey }}">
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
                {{ __('admin.new_clinic') }}
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






        <div class="col-6">
            <div class="form-group">
                <label for="first-name-column">{{ __('admin.comerical_record') }}</label>
                <div class="controls">
                    <input wire:model="comerical_record" type="number" name="comerical_record" class="form-control"
                           placeholder="{{ __('admin.record_number') }}"
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
                    <input wire:model="clinicName" type="text" name="name" class="form-control"
                           placeholder="{{ __('admin.name') }}"
                           data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                </div>
                @error('name')
                <span style="color: #ff3333">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-6">
            <div class="form-group">
                <label for="first-name-column">{{ __('admin.detection_price') }}</label>
                <div class="controls">
                    <input wire:model="detection_price" type="number" name="detection_price" class="form-control"
                           placeholder="{{ __('admin.detection_price') }}"
                           data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                </div>
                @error('detection_price')
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


        <div class="row w-100 justify-content-center" wire:loading.remove wire:target="store">
            <button class="btn mx-1 btn-primary nextBtn btn-lg pull-right" type="button"
                    wire:click="store">{{ __('admin.add') }}</button>
            <button class="btn mx-1 btn-danger nextBtn btn-lg pull-right" type="button"
                    wire:click="back(2)">{{ __('admin.back') }}</button>
        </div>

        <div class=" w-100 text-center" wire:loading wire:target="store">
            <div class="spinner-border text-warning" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>

    </div>
    {{--  ######################################################################## end step 3   --}}

    {{--  <div class="row setup-content {{ $currentStep != 3 ? 'display-none' : '' }}" id="step-3">
        <div class="col-md-12">
            <h3> Step 3</h3>

            <button class="btn btn-success btn-lg pull-right" wire:click="submitForm" type="button">Finish!</button>
            <button class="btn btn-danger nextBtn btn-lg pull-right" type="button"
                wire:click="back(2)">Back</button>
        </div>
    </div>  --}}


</div>
