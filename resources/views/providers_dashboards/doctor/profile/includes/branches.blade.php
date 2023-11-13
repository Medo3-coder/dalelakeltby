<div class="modal fade" id="exampleModal2" tabindex="-1" aria-labelledby="exampleModal2Label" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe">
        <div class="modal-content">

            <div class="modal-body no-border-bottom modal1-spe">
                <h5 class="font-17 font_bold mb-3 ">{{ __('doctor.Modify clinic data') }}</h5>
                <form action="{{ route('doctor.profile.store.update') }}" method="POST" enctype="multipart/form-data" class="form">
                    @csrf
                    @method('PUT')
                    <div class="add-append">
                        <input type="hidden" name="ids[]" value="{{ $firstBranch->id }}">
                        <input type="hidden" name="index[]" value="0">

                        <div class="branches">
                            <div class="spe-append-map position-relative ">
                                <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.name') }}</h6>
                                    <div class="form__label">
                                        <input class="default_input" type="text" name="name[]" value="{{ $firstBranch->name }}"  placeholder="{{ __('doctor.doctor.name_val') }}" />
                                        <label class="float__label" for="">{{ __('doctor.doctor.name_val') }}</label>
                                    </div>
                                    <div class="error_show error_name[0]"> </div>
                                </div>
                            </div>
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.address') }}</h6>
                                <div class="form__label">
                                    <input class="default_input" type="text" name="address[]" value="{{ $firstBranch->address }}"  placeholder="{{ __('doctor.doctor.address_val') }}" />
                                    <label class="float__label" for="">{{ __('doctor.doctor.address_val') }}</label>
                                </div>
                                <div class="error_show error_address[0]"> </div>
                            </div>
                            <div class="maps">
                                <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.address_map') }}</h6>
                                    <div class="form__label">
                                        <input readonly class="default_input address" type="text" name="address_map[]" value="{{ $firstBranch->address_map }}"  placeholder="{{ __('doctor.doctor.address_map') }}" />
                                        <label class="float__label" for="">{{ __('doctor.doctor.address_map_val') }}</label>
                                    </div>
                                    <div class="error_show error_address_map[0]"> </div>
                                </div>

                                <div
                                        id=""
                                        style="width: 100%; height: 300px"
                                        class="mb-3 map"
                                ></div>
                                <input type="hidden" class="lat" name="lat[]" value="{{ $firstBranch->lat }}">
                                <input type="hidden" class="lng" name="lng[]" value="{{ $firstBranch->lng }}">
                            </div>
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.comerical_record') }}</h6>
                                <div class="form__label">
                                    <input class="default_input" name="comerical_record[]" value="{{ $firstBranch->comerical_record }}" type="number"  placeholder="{{ __('doctor.doctor.comerical_record_val') }}" />
                                    <label class="float__label" for="">{{ __('doctor.doctor.comerical_record_val') }}</label>
                                </div>
                                <div class="error_show error_comerical_record[0]"> </div>
                            </div>
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('doctor.detection_price') }}</h6>
                                <div class="form__label">
                                    <input class="default_input" name="detection_price[]" value="{{ $firstBranch->detection_price }}" type="number"  placeholder="{{ __('doctor.detection_price_val') }}" />
                                    <label class="float__label" for="">{{ __('doctor.detection_price_val') }}</label>
                                </div>
                                <div class="error_show error_detection_price[0]"> </div>
                            </div>
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.images') }}</h6>
                                <div class="form__label">
                                    <label for="filesNext19_input" class="apload-img-reg">
                                        <input type="file" hidden onchange="abloadDefi(this)" id="filesNext19_input"
                                               class="heddenUploud files-input" multiple name="images-0[]" data-input="filesNext19" />
                                        <div class="add-photo">
                                            <i class="fa-solid fa-images"></i>
                                        </div>
                                        <div class="img-apload-title">{{ __('doctor.doctor.images_val') }}</div>
                                    </label>
                                    <div class="error_show error_images-0"> </div>
                                </div>
                                <div class="uploaded__area" id="filesNext19_cont">
                                    @forelse($firstBranch->images as $image)
                                        <div class="file_">
                                            <input type="hidden" name="imagesIds-0[]" value="{{ $image->id }}"></input>
                                            <a data-fancybox="gallery" href="{{ $image->image }}">
                                                <img src="{{ $image->image }}" alt="">
                                            </a>
                                            <div class="btn remove_media" onclick="deleteImage(this)">
                                                <ion-icon name="close-outline"></ion-icon>
                                            </div>
                                        </div>

                                    @empty
                                    @endforelse


                                </div>
                            </div>
                            <div class="work-date-container form-section-style main-inp-cont">
                                <h6 class="fontBold mainColor font14">{{ __('store.store_times') }}</h6>

                                <div class="work-date-content ">
                                    <div class="work-parent row g-0">
                                        @forelse($firstBranch->dates as $key => $date)
                                            <div class="work-date times-cont col-md-12">
                                                <div class="row g-2">
                                                    <div class="input-work col-6 col-sm-6 col-md-4">
                                                        <div class="input-icon">
                                                            <select name="times[days-0][]" id="" class="default_input">
                                                                <option value="saturday" {{ $date->day == 'saturday' ? 'selected' : '' }}>{{ __('store.saturday') }}</option>
                                                                <option value="sunday" {{ $date->day == 'sunday' ? 'selected' : '' }}>{{ __('store.sunday') }}</option>
                                                                <option value="monday" {{ $date->day == 'monday' ? 'selected' : '' }}>{{ __('store.monday') }}</option>
                                                                <option value="tuesday" {{ $date->day == 'tuesday' ? 'selected' : '' }}>{{ __('store.tuesday') }}</option>
                                                                <option value="wednesday" {{ $date->day == 'wednesday' ? 'selected' : '' }}>{{ __('store.wednesday') }}</option>
                                                                <option value="thursday" {{ $date->day == 'thursday' ? 'selected' : '' }}>{{ __('store.thursday') }}</option>
                                                                <option value="friday" {{ $date->day == 'friday' ? 'selected' : '' }}>{{ __('store.friday') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="input-work col-6 col-sm-6 col-md-4">
                                                        <input type="text" name="times[from-0][]" value="{{ $date->from }}" placeholder="{{ __('store.from') }}" class="from-date from" id="time1" />
                                                        <label class="add-photo" for="time1">
                                                            <i class="fa-regular fa-clock"></i>
                                                        </label>
                                                    </div>
                                                    <div class="input-work col-6 col-sm-6 col-md-4">
                                                        <input type="text" name="times[to-0][]" value="{{ $date->to }}" placeholder="{{ __('store.to') }}" class="to-date to" id="time2" />
                                                        <label class="add-photo" for="time2">
                                                            <i class="fa-regular fa-clock"></i>
                                                        </label>
                                                    </div>
                                                    @if($key != 0)
                                                        <div class="work-close-icon" onclick="deleteDate(this)"> <i class="fa-solid fa-xmark"></i> </div>
                                                    @endif

                                                </div>
                                            </div>
                                        @empty
                                            <div class="work-date times-cont col-md-12">
                                                <div class="row g-2">
                                                    <div class="input-work col-6 col-sm-6 col-md-4">
                                                        <div class="input-icon">
                                                            <select name="times[days-0][]" id="" class="default_input">
                                                                <option value="saturday" >{{ __('store.saturday') }}</option>
                                                                <option value="sunday">{{ __('store.sunday') }}</option>
                                                                <option value="monday">{{ __('store.monday') }}</option>
                                                                <option value="tuesday">{{ __('store.tuesday') }}</option>
                                                                <option value="wednesday">{{ __('store.wednesday') }}</option>
                                                                <option value="thursday">{{ __('store.thursday') }}</option>
                                                                <option value="friday">{{ __('store.friday') }}</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="input-work col-6 col-sm-6 col-md-4">
                                                        <input type="text" name="times[from-0][]" value="" placeholder="{{ __('store.from') }}" class="from-date from" id="time1" />
                                                        <label class="add-photo" for="time1">
                                                            <i class="fa-regular fa-clock"></i>
                                                        </label>
                                                    </div>
                                                    <div class="input-work col-6 col-sm-6 col-md-4">
                                                        <input type="text" name="times[to-0][]" value="" placeholder="{{ __('store.to') }}" class="to-date to" id="time2" />
                                                        <label class="add-photo" for="time2">
                                                            <i class="fa-regular fa-clock"></i>
                                                        </label>
                                                    </div>

                                                </div>
                                            </div>
                                        @endforelse


                                    </div>
                                    <div class="work-plus-icon" onclick="appendDateMain(this, 0)">
                                        <div class="plus-add">{{ __('store.add new') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @forelse($branches as $branch)
                                <?php
                                $i = $i + 1;
                                ?>

                            <div class="branches">
                                <input type="hidden" name="ids[]" value="{{ $branch->id }}">
                                <input type="hidden" name="index[]" value="{{ $i }}">
                                <div class="spe-append-map position-relative ">
                                    <div class="work-close-icon mb-5 top-def" onclick="deleteBranch(this)"><i class="fa-solid fa-xmark"></i></div>

                                    <div class="mb-3 main-inp-cont">
                                        <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.name') }}</h6>
                                        <div class="form__label">
                                            <input class="default_input" type="text" name="name[{{ $i}}]" value="{{ $branch->name }}"  placeholder="{{ __('doctor.doctor.name_val') }}" />
                                            <label class="float__label" for="">{{ __('doctor.doctor.images_val') }}</label>
                                        </div>
                                        <div class="error_show error_name[{{ $i }}]"> </div>
                                    </div>
                                </div>
                                <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.address') }}</h6>
                                    <div class="form__label">
                                        <input class="default_input" type="text" name="address[{{ $i }}]" value="{{ $branch->address }}"  placeholder="{{ __('doctor.doctor.address_val') }}" />
                                        <label class="float__label" for="">{{ __('doctor.doctor.address_val') }}</label>
                                    </div>
                                    <div class="error_show error_address[{{ $i }}]"> </div>
                                </div>

                                <div class="maps">
                                    <div class="mb-3 main-inp-cont">
                                        <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.address_map') }}</h6>
                                        <div class="form__label">
                                            <input readonly class="default_input address" type="text" name="address_map[{{ $i }}]" value="{{ $branch->address_map }}"  placeholder="{{ __('doctor.doctor.address_map_val') }}" />
                                            <label class="float__label" for="">{{ __('doctor.doctor.address_map_address') }}</label>
                                        </div>
                                        <div class="error_show error_address_map[{{ $i }}]"> </div>
                                    </div>

                                    <div
                                            id=""
                                            style="width: 100%; height: 300px"
                                            class="mb-3 map"
                                    ></div>
                                    <input type="hidden" class="lat" name="lat[{{ $i }}]" value="{{ $branch->lat }}">
                                    <input type="hidden" class="lng" name="lng[{{ $i }}]" value="{{ $branch->lng }}">
                                </div>


                                <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.comerical_record') }}</h6>
                                    <div class="form__label">
                                        <input class="default_input" name="comerical_record[{{ $i }}]" value="{{ $branch->comerical_record }}" type="number"  placeholder="{{ __('doctor.doctor.comerical_record_val') }}" />
                                        <label class="float__label" for="">{{ __('doctor.doctor.comerical_record_val') }}</label>
                                    </div>
                                    <div class="error_show error_comerical_record[{{ $i }}]"> </div>
                                </div>

                                <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">{{ __('doctor.detection_price') }}</h6>
                                    <div class="form__label">
                                        <input class="default_input" name="detection_price[{{ $i }}]" value="{{ $branch->detection_price }}" type="number"  placeholder="{{ __('doctor.detection_price_val') }}" />
                                        <label class="float__label" for="">{{ __('doctor.detection_price_val') }}</label>
                                    </div>
                                    <div class="error_show error_detection_price[{{ $i }}]"> </div>
                                </div>
                                <div class="mb-3 main-inp-cont">
                                    <h6 class="fontBold mainColor font14">{{ __('doctor.doctor.images') }}</h6>
                                    <div class="form__label">
                                        <label for="filesNext4{{ $i }}_input" class="apload-img-reg">
                                            <input type="file" hidden onchange="abloadDefi(this)" id="filesNext4{{ $i }}_input"
                                                   class="heddenUploud files-input" multiple name="images-{{ $i }}[]" data-input="filesNext4{{ $i }}" />
                                            <div class="add-photo">
                                                <i class="fa-solid fa-images"></i>
                                            </div>
                                            <div class="img-apload-title">{{ __('doctor.doctor.images_val') }}</div>
                                        </label>
                                        <div class="error_show error_images-{{ $i }}"> </div>
                                    </div>
                                    <div class="uploaded__area" id="filesNext4{{ $i }}_cont">
                                        @forelse($branch->images as $image)
                                            <div class="file_">
                                                <input type="hidden" name="imagesIds-{{ $i }}[]" value="{{ $image->id }}"></input>
                                                <a data-fancybox="gallery" href="{{ $image->image }}">
                                                    <img src="{{ $image->image }}" alt="">
                                                </a>
                                                <div class="btn remove_media" onclick="deleteImage(this)">
                                                    <ion-icon name="close-outline"></ion-icon>
                                                </div>
                                            </div>

                                        @empty
                                        @endforelse


                                    </div>
                                </div>
                                <div class="work-date-container form-section-style main-inp-cont">
                                    <h6 class="fontBold mainColor font14">{{ __('store.store_times') }}</h6>

                                    <div class="work-date-content ">
                                        <div class="work-parent row g-0">
                                            @forelse($branch->dates as $key => $date)

                                                <div class="work-date times-cont col-md-12">
                                                    <div class="row g-2">
                                                        <div class="input-work col-6 col-sm-6 col-md-4">
                                                            <div class="input-icon">
                                                                <select name="times[days-{{ $i }}][]" id="" class="default_input">
                                                                    <option value="saturday" {{ $date->day == 'saturday' ? 'selected' : '' }}>{{ __('store.saturday') }}</option>
                                                                    <option value="sunday" {{ $date->day == 'sunday' ? 'selected' : '' }}>{{ __('store.sunday') }}</option>
                                                                    <option value="monday" {{ $date->day == 'monday' ? 'selected' : '' }}>{{ __('store.monday') }}</option>
                                                                    <option value="tuesday" {{ $date->day == 'tuesday' ? 'selected' : '' }}>{{ __('store.tuesday') }}</option>
                                                                    <option value="wednesday" {{ $date->day == 'wednesday' ? 'selected' : '' }}>{{ __('store.wednesday') }}</option>
                                                                    <option value="thursday" {{ $date->day == 'thursday' ? 'selected' : '' }}>{{ __('store.thursday') }}</option>
                                                                    <option value="friday" {{ $date->day == 'friday' ? 'selected' : '' }}>{{ __('store.friday') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="input-work col-6 col-sm-6 col-md-4">
                                                            <input type="text" name="times[from-{{ $i }}][]" value="{{ $date->from }}" placeholder="{{ __('store.from') }}" class="from-date from" id="time1" />
                                                            <label class="add-photo" for="time1">
                                                                <i class="fa-regular fa-clock"></i>
                                                            </label>
                                                        </div>
                                                        <div class="input-work col-6 col-sm-6 col-md-4">
                                                            <input type="text" name="times[to-{{ $i }}][]" value="{{ $date->to }}" placeholder="{{ __('store.to') }}" class="to-date to" id="time2" />
                                                            <label class="add-photo" for="time2">
                                                                <i class="fa-regular fa-clock"></i>
                                                            </label>
                                                        </div>
                                                        @if($key != 0)
                                                            <div class="work-close-icon" onclick="deleteDate(this)"> <i class="fa-solid fa-xmark"></i> </div>
                                                        @endif

                                                    </div>
                                                </div>
                                            @empty

                                                <div class="work-date times-cont col-md-12">
                                                    <div class="row g-2">
                                                        <div class="input-work col-6 col-sm-6 col-md-4">
                                                            <div class="input-icon">
                                                                <select name="times[days-{{ $i }}][]" id="" class="default_input">
                                                                    <option value="saturday" >{{ __('store.saturday') }}</option>
                                                                    <option value="sunday">{{ __('store.sunday') }}</option>
                                                                    <option value="monday">{{ __('store.monday') }}</option>
                                                                    <option value="tuesday">{{ __('store.tuesday') }}</option>
                                                                    <option value="wednesday">{{ __('store.wednesday') }}</option>
                                                                    <option value="thursday">{{ __('store.thursday') }}</option>
                                                                    <option value="friday">{{ __('store.friday') }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="input-work col-6 col-sm-6 col-md-4">
                                                            <input type="text" name="times[from-{{ $i }}][]" value="" placeholder="{{ __('store.from') }}" class="from-date from" id="time1" />
                                                            <label class="add-photo" for="time1">
                                                                <i class="fa-regular fa-clock"></i>
                                                            </label>
                                                        </div>
                                                        <div class="input-work col-6 col-sm-6 col-md-4">
                                                            <input type="text" name="times[to-{{ $i }}][]" value="" placeholder="{{ __('store.to') }}" class="to-date to" id="time2" />
                                                            <label class="add-photo" for="time2">
                                                                <i class="fa-regular fa-clock"></i>
                                                            </label>
                                                        </div>

                                                    </div>
                                                </div>

                                            @endforelse


                                        </div>
                                        <div class="work-plus-icon" onclick="appendDateMain(this, {{ $i }})">
                                            <div class="plus-add">{{ __('store.add new') }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        @empty
                        @endforelse
                    </div>


                    <button onclick="appendAll()" class="dafult-blue-btn up" type="button">
                        {{ __('doctor.Add a new clinic') }}
                    </button>
                    <button class="submit wid-80-spe mt-5 submit-button"
                            type="submit">{{ __('store.Save changes') }}</button>
                </form>

            </div>
        </div>
    </div>
</div>
