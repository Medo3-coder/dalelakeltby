<!-- Modal 1 -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe">
        <div class="modal-content">
            <div class="modal-header no-border-bottom">
                <h5 class="modal-title font_bold modal7-spe" id="exampleModalLabel">
                    @lang('doctor.medical_record_and_receipt')
                </h5>
            </div>
            <div class="modal-body no-border-bottom modal7-spe">
                <div class="personal-data">
                    <div class="personal-row">
                        <div class="personal-row-part">
                            @lang('site.paient_name') : <span>{{ $reservation->name }}</span>
                        </div>
                        <div class="personal-row-part">
                            @lang('doctor.patient_age') : <span>{{ $reservation->age }}</span>
                        </div>
                        <div class="personal-row-part">
                            @lang('doctor.bloodType') :
                            <span>{{ $reservation->reservation_for == 'same_person' ? $reservation->user->bloodType->name : $reservation->patientBloodType->name }}</span>
                        </div>
                    </div>
                </div>
                <form method="POST" action="{{ route('doctor.reservations.writePrescription') }}"
                    data-success="$('#exampleModal3').modal('show');$('#perciptionModel').prepend(window.response.html); addrejeeimg()"
                    class="form form-modal1">
                    @csrf
                    <input type="hidden" name="reservation_id" value="{{ $reservation->id }}">
                    <div class="mb-3 main-inp-cont">
                        <h6 class="fontBold mainColor font14">@lang('doctor.diagnose')</h6>
                        <div class="form__label">
                            <input name="diagnosis" class="default_input" type="text" required=""
                                placeholder="@lang('doctor.enter_dignose')" />
                            <label class="float__label" for="">@lang('doctor.enter_dignose')</label>
                        </div>
                    </div>
                    <div class="main-clone-to-me">
                        <div class="mb-3 main-inp-cont">
                            <h6 class="fontBold mainColor font14">@lang('doctor.medicine')</h6>
                            <select name="medicines[]" required id="" class="default2-select gr">
                                <option value="" selected disabled>
                                    @lang('doctor.choose_medicine')
                                </option>
                                @foreach (provider('doctor')->medicines as $medicine)
                                    <option value="{{ $medicine->id }}">{{ $medicine->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="grid-cart">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">@lang('doctor.every_hm_hour')</h6>
                                <select name="hours[]" required id="" class="default2-select gr">
                                    <option value="" selected disabled>
                                        @lang('doctor.select_dose_time')
                                    </option>
                                    <option value=".5">@lang('doctor.half_hour')</option>
                                    <option value="1">@lang('doctor.hour')</option>
                                    @for ($i = 2; $i <= 24; $i++)
                                        <option value="{{ $i }}"> {{ $i }} @lang('doctor.hour')
                                        </option>
                                    @endfor
                                    @for ($i = 24; $i < 24 * 7; $i += 24)
                                        <option value="{{ $i }}"> {{ $i / 24 }} @lang('doctor.day')
                                        </option>
                                    @endfor
                                    <option value="168">
                                        @lang('doctor.week')
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">@lang('doctor.number_of_times')</h6>
                                <select name="times[]" required id="" class="default2-select gr">
                                    <option value="" selected disabled>
                                        @lang('doctor.select_number_of_times')
                                    </option>
                                    <option value="1">@lang('doctor.single_time')</option>
                                    <option value="2">@lang('doctor.two_times')</option>
                                    <option value="3">3 @lang('doctor.number_times')</option>
                                    <option value="4">4 @lang('doctor.number_times')</option>
                                    <option value="5">5 @lang('doctor.number_times')</option>
                                    <option value="6">6 @lang('doctor.number_times')</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="work-plus-icon" onclick="addClonedMedicine()">
                        <div class="plus-add">@lang('doctor.add_medicine')</div>
                    </div>
                    <div class="mb-3 main-inp-cont">
                        <h6 class="fontBold mainColor font14">@lang('doctor.chronic_disease')</h6>
                        <select name="is_charnic_disease" id="" class="default2-select gr">
                            <option value="" selected disabled>
                                @lang('doctor.select_is_charonic_disease')
                            </option>
                            <option value="1">@lang('doctor.charonic')</option>
                            <option value="0">@lang('doctor.not_charonic')</option>
                        </select>
                    </div>
                    <div style="display: none" class="chranic_disease_cont mb-3 main-inp-cont">
                        <select disabled name="chranic_disease_id" id="" class="default2-select gr">
                            <option value="" selected disabled>
                                @lang('doctor.select_charonic_disease')
                            </option>

                            @foreach ($charnicDiseases as $disease)
                                <option value="{{ $disease->id }}">{{ $disease->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="main-inp-cont spe-borr">

                        <h6>@lang('doctor.choose_regite')</h6>
                    </div>
                    <div class="modal-3-img-con mt-3">
                        <div class="row">

                            @foreach ($ragites as $key => $ragite)
                                <div class="col-lg-3 col-md-6 col-12">
                                    <div class="img-box-s">
                                        <button class="show-sh" type="button" >
                                            <input type="radio"
                                                value="{{ $ragite->id }}" name="ragite_id" />
                                            <label data-toggle="modal"
                                                   data-target="#staticBackdrop"
                                                class="per-label2">@lang('doctor.view_template_before_choose')</label>
                                        </button>
                                        <img src="{{ $ragite->image }}" alt="" />
                                    </div>
                                </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="error_show error_ragite_id"> </div>
                    {{--  <div class="main-inp-cont spe-borr">
                        <h6>اختيار الخلفية حسب التخصص</h6>
                    </div>
                    <div class="modal-3-img-con mt-3">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="img-box-s">
                                    <button class="show-sh2" type="button">
                                        <input type="radio" name="showdone2" />
                                        <label
                                                data-toggle="modal"
                                                data-target="#staticBackdrop"
                                                class="per-label2"
                                        >معاينة النموذج قبل اختياره</label
                                        >
                                    </button>
                                    <img
                                            src="../lab dashboard/imgs/Component 51 – 1.png"
                                            alt=""
                                    />
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-12">
                                <div class="img-box-s">
                                    <button class="show-sh2" type="button">
                                        <input type="radio" name="showdone2" />
                                        <label
                                                data-toggle="modal"
                                                data-target="#staticBackdrop"
                                                class="per-label2"
                                        >معاينة النموذج قبل اختياره</label
                                        >
                                    </button>
                                    <img src="../lab dashboard/imgs/bell.png" alt="" />
                                </div>
                            </div>

                        </div>
                    </div>  --}}
{{--                    --}}{{--  <div class="main-inp-cont spe-borr mt-3">--}}
{{--                        <h6>اختيار خلفية الراجيتة حسب التخصص</h6>--}}
{{--                    </div>--}}
{{--                    <div class="modal-3-img-con mt-4">--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-lg-3 col-md-6 col-12">--}}
{{--                                <div class="img-box-s">--}}
{{--                                    <button class="show-sh" type="button" data-toggle="modal"--}}
{{--                                        data-target="#staticBackdropdouble">--}}
{{--                                        <input type="radio" id="show-db1" name="dbdone" />--}}
{{--                                        <label for="show-db1" class="per-label">معاينة النموذج قبل اختياره</label>--}}
{{--                                    </button>--}}
{{--                                    <img src="{{asset('dashboard/imgs/sss.jpg')}}" alt="" />--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-3 col-md-6 col-12">--}}
{{--                                <div class="img-box-s">--}}
{{--                                    <button class="show-sh" type="button" data-toggle="modal"--}}
{{--                                        data-target="#staticBackdropdouble">--}}
{{--                                        <input type="radio" id="show-db2" name="dbdone" />--}}
{{--                                        <label for="show-db2" class="per-label">معاينة النموذج قبل اختياره</label>--}}
{{--                                    </button>--}}
{{--                                    <img src="../lab dashboard/imgs/vvvv.jpg" alt="" />--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-3 col-md-6 col-12">--}}
{{--                                <div class="img-box-s">--}}
{{--                                    <button class="show-sh" type="button" data-toggle="modal"--}}
{{--                                        data-target="#staticBackdropdouble">--}}
{{--                                        <input type="radio" id="show-db3" name="dbdone" />--}}
{{--                                        <label for="show-db3" class="per-label">معاينة النموذج قبل اختياره</label>--}}
{{--                                    </button>--}}
{{--                                    <img src="../lab dashboard/imgs/318354221_697984298444496_7577338281760416973_n.jpg"--}}
{{--                                        alt="" />--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-3 col-md-6 col-12">--}}
{{--                                <div class="img-box-s">--}}
{{--                                    <button class="show-sh" type="button" data-toggle="modal"--}}
{{--                                        data-target="#staticBackdropdouble">--}}
{{--                                        <input type="radio" name="dbdone" id="db-sh4" />--}}
{{--                                        <label for="db-sh4" class="per-label">معاينة النموذج قبل اختياره</label>--}}
{{--                                    </button>--}}
{{--                                    <img src="../lab dashboard/imgs/NoPath - Copy (84).png" alt="" />--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>  --}}
                    <div class="d-flex align-items-center justify-content-end">
                        <button type="button" data-toggle="modal" data-target="#exampleModal6Rajite"
                            class="submit-3 bg-green up mt-3">
                            @lang('doctor.add_personal_model')
                        </button>
                        <button class="submit-3 up submit-button mt-3">
                            @lang('doctor.save_receipt')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


