    {{-- start labs results --}}
    @if ($reservation->children->where('status', 'finished')->count() > 0)
        <!-- Modal 6 -->
        <div class="modal fade" id="exampleModal6" tabindex="-1" aria-labelledby="exampleModal3Label"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-spe">
                <div class="modal-content">
                    <div class="modal-header no-border-bottom close-modal">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    @foreach ($reservation->children->where('status', 'finished') as $labReservation)
                        <div class="modal-body no-border-bottom modal2-spe">
                            <h5 class="font_bold text-center mb-3">{{ $labReservation->lab->name }}</h5>
                            <div class="modal3-title">
                                @lang('doctor.sender_doctor') :
                                <span>{{ $reservation->doctor->name }}</span>
                            </div>
                            <div class="modal-big-tit text-center">@lang('doctor.test_result')</div>
                            <div class="flex-m-1">
                                <div class="right-m-1">
                                    <div class="patient-box">@lang('site.paient_name')</div>
                                    <div class="patient-box">{{ $labReservation->name }}</div>
                                </div>
                                <div class="right-m-1">
                                    <div class="patient-box">@lang('doctor.visiting_time')</div>
                                    <div class="patient-box">{{ $labReservation->time }}</div>
                                </div>
                                <div class="right-m-1">
                                    <div class="patient-box">@lang('doctor.visiting_date')</div>
                                    <div class="patient-box">{{ $labReservation->date->toDateString() }}</div>
                                </div>
                            </div>
                            <div class="flex-m-2">
                                <div class="right-m-1">
                                    <div class="patient-box">@lang('doctor.age/gender')</div>
                                    <div class="patient-box">
                                        {{ $labReservation->age . ' / ' . __('doctor.' . $labReservation->gender) }}
                                    </div>
                                </div>
                                <div class="right-m-1">
                                    <div class="patient-box">@lang('site.serial_number')</div>
                                    <div class="patient-box">{{ $labReservation->id }}</div>
                                </div>
                            </div>

                            @foreach ($labReservation->labSubcategoryReservationHasMany as $test)
                                <div class="flex-m-3">
                                    <div class="right-n-1">
                                        <div class="patient-box">Units</div>
                                        <div class="patient-box-spe">{{ $test->subCategoryLab->unit }}</div>
                                    </div>
                                    <div class="right-n-1">
                                        <div class="right-n-1">
                                            <div class="patient-box">Normal Range</div>
                                            <div class="patient-box-spe">{{ $test->subCategoryLab->normal_range }}</div>
                                        </div>
                                    </div>
                                    <div class="right-n-1">
                                        <div class="right-n-1">
                                            <div class="patient-box">Result</div>
                                            <div class="patient-box-spe">{{ $test->result }}</div>
                                        </div>
                                    </div>
                                    <div class="right-n-1">
                                        <div class="right-n-1">
                                            <div class="patient-box">Test Name</div>
                                            <div class="patient-box-spe">{{ $test->subCategoryLab->labSubCategory->name }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                            <div class="mt-3 en-dir">
                                <h6 class="fontBold mainColor mb-1 font14 color-main font_bold mb-1">
                                    @lang('doctor.report')
                                </h6>
                                <p class="m-para">
                                    {{ $labReservation->lab_report }}
                                </p>
                            </div>
                            <div class="modal-3-img-con mt-4">
                                <div class="row">
                                    @foreach ($labReservation->images as $image)
                                        <div class="col-lg-3 col-md-6 col-12 mt-3 mb-2">
                                            <div class="img-box-s">
                                                <img src="{{ $image->image }}" alt="" />
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    {{-- end labs results --}}