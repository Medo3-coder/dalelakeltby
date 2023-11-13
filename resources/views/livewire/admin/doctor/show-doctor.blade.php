    <div class="row " id="step-1">
        <div class="imgMontg col-2 text-center">
            <div class="dropBox">
                <div class="textCenter">
                    <div  class="imagesUploadBlock">
                        <label class="uploadImg">
                            <span><i class="feather icon-image"></i></span>
                            <input disabled type="file" class="imageUploader" accept="image/*" wire:model="image"
                                name="image">
                        </label>
                        @if ($currentDoctor->image)
                            <div class="uploadedBlock"><img src="{{ $currentDoctor->image }}"><button
                                    class="close"><i class="la la-times"></i></button></div>
                        @endif
                    </div>
                    <div class="col">
                        <h6 class="bold font14">{{ __('admin.image') }}
                        </h6>
                    </div>
                </div>
            </div>
        </div>

        <div class="imgMontg col-2 text-center">
            <div class="dropBox">
                <div class="textCenter">
                    <div  class="imagesUploadBlock">
                        <label class="uploadImg">
                            <span><i class="feather icon-image"></i></span>
                            <input disabled type="file" accept="image/*" wire:model="identity_image"
                                name="image" class="imageUploader">
                        </label>
                        @if ($currentDoctor->identity_image)
                            <div class="uploadedBlock"><img
                                    src="{{ $currentDoctor->identity_image }}"><button class="close"><i
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

        <div class="imgMontg col-2 text-center">
            <div class="dropBox">
                <div class="textCenter">
                    <div  class="imagesUploadBlock">
                        <label class="uploadImg">
                            <span><i class="feather icon-image"></i></span>
                            <input disabled type="file" accept="image/*" wire:model="identity_image"
                                name="image" class="imageUploader">
                        </label>
                        @if ($currentDoctor->graduation_certification_image)
                            <div class="uploadedBlock"><img
                                    src="{{ $currentDoctor->graduation_certification_image }}"><button class="close"><i
                                        class="la la-times"></i></button></div>
                        @endif

                    </div>
                    <div class="col">
                        <h6 class="bold font14">{{ __('admin.graduation_certification_image') }}
                        </h6>
                    </div>
                    @error('graduation_certification_image')
                        <span style="color: #ff3333">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="imgMontg col-2 text-center">
            <div class="dropBox">
                <div class="textCenter">
                    <div  class="imagesUploadBlock">
                        <label class="uploadImg">
                            <span><i class="feather icon-image"></i></span>
                            <input disabled type="file" accept="image/*" 
                                name="image" class="imageUploader">
                        </label>
                        @if ($currentDoctor->practice_certification_image)
                            <div class="uploadedBlock"><img
                                    src="{{ $currentDoctor->practice_certification_image }}"><button class="close"><i
                                        class="la la-times"></i></button></div>
                        @endif

                    </div>
                    <div class="col">
                        <h6 class="bold font14">{{ __('admin.practice_certification_image') }}
                        </h6>
                    </div>
                    @error('practice_certification_image')
                        <span style="color: #ff3333">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="imgMontg col-2 text-center">
            <div class="dropBox">
                <div class="textCenter">
                    <div  class="imagesUploadBlock">
                        <label class="uploadImg">
                            <span><i class="feather icon-image"></i></span>
                            <input disabled type="file" accept="image/*" 
                                name="image" class="imageUploader">
                        </label>
                        @if ($currentDoctor->experience_certification_image)
                            <div class="uploadedBlock"><img
                                    src="{{ $currentDoctor->experience_certification_image }}"><button class="close"><i
                                        class="la la-times"></i></button></div>
                        @endif

                    </div>
                    <div class="col">
                        <h6 class="bold font14">{{ __('admin.experience_certification_image') }}
                        </h6>
                    </div>
                    @error('experience_certification_image')
                        <span style="color: #ff3333">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="first-name-column">{{ __('admin.name') }}</label>
                <div class="controls">
                    <input disabled type="text" wire:model="name" name="name" class="form-control"
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
                    <input disabled type="text" wire:model="nickname" class="form-control"
                        placeholder="{{ __('admin.nickname') }}" required
                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                </div>
                @error('nickname')
                    <span style="color: #ff3333">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="col-md-6 col-12">
            <div class="form-group">
                <label for="first-name-column">{{ __('admin.email') }}</label>
                <div class="controls">
                    <input disabled type="email" wire:model="email" class="form-control"
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
                    <select disabled style="width: 20% ; position: absolute; left: 3%;" wire:model="country_code"
                        name="country_code" class="select2 form-control" required
                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                        @foreach ($keys as $key)
                            <option value="{{ $key->key }}">
                                {{ $key->key }}</option>
                        @endforeach
                    </select>
                    <input disabled type="number" minlength="9" maxlength="11" wire:model="phone"
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
                    <input disabled type="number" wire:model="age" class="form-control"
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
                    <input disabled type="password" wire:model="password" class="form-control"
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
                    <input disabled type="number" wire:model="identity_number" name="identity_number"
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
                    <select disabled wire:model="is_blocked" name="block" class="select2 form-control" required
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
                    <select disabled wire:model="category_id" name="block" class="select2 form-control" required
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
                        <select disabled wire:model="speciality_id" name="block" class="select2 form-control"
                            required
                            data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                            <option disabled selected>
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

        <div class="col-md-12 col-12">
            <div class="form-group">
                <div class="controls">
                    <label for="account-name">{{ __('admin.qualifications') }}</label>
                    <textarea disabled wire:model="qualifications" class="form-control" cols="30" rows="10"
                        placeholder="{{ __('admin.qualifications') }}"></textarea>
                </div>
            </div>
        </div>

        <div class="col-md-12 col-12">
            <div class="form-group">
                <div class="controls">
                    <label for="account-name">{{ __('doctor.abstract') }}</label>
                    <textarea disabled wire:model="abstract" class="form-control" cols="30" rows="10"
                        placeholder="{{ __('doctor.abstract') }}"></textarea>
                </div>
            </div>
        </div>

        

        <div class="col-12">
            <h5>{{ __('admin.qualifications') }}</h5>
        </div>

        <div class="form-group col-4">
            <label for="first-name-column">{{ __('admin.graduation_certification_pdf') }}</label>
            <div class="controls">
                <a href="{{ $currentDoctor->graduation_certification_pdf }}" download=""> <i class="feather icon-arrow-down">  </i></a>
            </div>
        </div>

        <div class="form-group  col-4">
            <label for="first-name-column">{{ __('admin.practice_certification_pdf') }}</label>
            <div class="controls">
                <a href="{{ $currentDoctor->practice_certification_pdf }}" download=""> <i class="feather icon-arrow-down">  </i></a>
            </div>
        </div>
        <div class="form-group  col-4">
            <label for="first-name-column">{{ __('admin.experience_certification_pdf') }}</label>
            <div class="controls">
                <a href="{{ $currentDoctor->experience_certification_pdf }}" download=""> <i class="feather icon-arrow-down">  </i></a>
            </div>
        </div>

        <div class="col-12">
            <div class="form-group">
                <label for="first-name-column">{{ __('admin.experience_years') }}</label>
                <div class="controls">
                    <input disabled wire:model="experience_years" type="number" name="experience_years" class="form-control"
                        placeholder="{{ __('admin.experience_years') }}"
                        data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                </div>
                @error('experience_years')
                    <span style="color: #ff3333">{{ $message }}</span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <h5 class="mb-2">{{ __('admin.clinics') }}</h5>

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
                            {{-- @if (!in_array($branch['id'], $deletedBranches) && count($this->currentBranches) + count($this->branches) > 1)
                                <button wire:click="deleteCurrentBranch({{ $branch['id'] }})" type="button"
                                    class="btn btn-icon btn-icon rounded-circle btn-danger mr-1 waves-effect waves-light"><i
                                        class="feather icon-trash"></i></button>
                            @elseif(in_array($branch['id'], $deletedBranches))
                                <button wire:click="undoDeleteBranch({{ $branch['id'] }})" type="button"
                                    class="btn btn-icon btn-icon rounded-circle btn-warning mr-1 waves-effect waves-light"><i
                                        class="fa fa-undo"></i></button>
                            @endif --}}


                        </span>
                        <span wire:loading wire:target="deleteCurrentBranch,undoDeleteBranch">
                            <div class="spinner-border text-warning" role="deleteWorkingTime">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </span>
                    </div>
                    <div id="collapseww{{ $key . 'current' }}" class="p-2 collapse" role="tabpanel"
                        aria-labelledby="headingCollapserr{{ $key . 'current' }}" class="collapse" style="">

                        <div  class="row mt-2">
                            <div class="col-md-3">{{ __('admin.images') }}</div>
                            <div class="col">
                                @foreach ($branch['images'] as $bImageKey => $bImage)
                                    <img src="{{ $bImage->temporaryUrl() }}"
                                        wire:key='bimagekey{{ $key . 'current' . 'aa' . $bImageKey }}'
                                        class="m-2" height="150" alt="">
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

                        <div  class="row mt-2">
                            <div class="col-md-3">{{ __('admin.comerical_record') }}</div>
                            <div class="col"> {{ $branch['comerical_record'] }} </div>
                        </div>

                        <div  class="row mt-2">
                            <div class="col-md-3">{{ __('admin.detection_price') }}</div>
                            <div class="col"> {{ $branch['detection_price'] }} </div>
                        </div>

                        <div  class="row mt-2">
                            <div class="col-md-3">{{ __('admin.address') }}</div>
                            <div class="col"> {{ $branch['address'] }} </div>
                        </div>

                        <div  class="row mt-2">
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
                            <div class="card  collapse-header">
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

                                    <div  class="row mt-2">
                                        <div class="col-md-3">{{ __('admin.images') }}</div>
                                        <div class="col">
                                            @foreach ($branch['images'] as $bImageKey => $bImage)
                                                <img src="{{ $bImage->temporaryUrl() }}"
                                                    wire:key='bimagekey{{ $newBranchKey . 'aa' . $bImageKey }}'
                                                    class="m-2" height="150" alt="">
                                            @endforeach
                                        </div>
                                    </div>



                                    <div  class="row mt-2">
                                        <div class="col-md-3">{{ __('admin.comerical_record') }}</div>
                                        <div class="col"> {{ $branch['comerical_record'] }} </div>
                                    </div>

                                    <div  class="row mt-2">
                                        <div class="col-md-3">{{ __('admin.detection_price') }}</div>
                                        <div class="col"> {{ $branch['detection_price'] }} </div>
                                    </div>

                                    <div  class="row mt-2">
                                        <div class="col-md-3">{{ __('admin.address') }}</div>
                                        <div class="col"> {{ $branch['address'] }} </div>
                                    </div>

                                    <div  class="row mt-2">
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

        </div>

    </div>


