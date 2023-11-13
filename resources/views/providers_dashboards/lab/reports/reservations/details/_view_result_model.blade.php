<!-- Modal 3 -->
<div class="modal fade" id="viewResultModal" tabindex="-1" aria-labelledby="viewResultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe">
        <div class="modal-content">
            <div class="modal-header no-border-bottom close-modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body no-border-bottom modal2-spe">
                <h5 class="font_bold text-center mb-3">{{ $reservation->lab->name }}</h5>
                @if ($reservation->doctor)
                    <div class="modal3-title">
                        @lang('doctor.sender_doctor') :
                        <span>{{ $reservation->doctor?->name }}</span>
                    </div>
                @endif

                <div class="modal-big-tit text-center">@lang('doctor.test_result')</div>
                <div class="flex-m-1">
                    <div class="right-m-1">
                        <div class="patient-box">@lang('site.paient_name')</div>
                        <div class="patient-box">{{ $reservation->name }}</div>
                    </div>
                    <div class="right-m-1">
                        <div class="patient-box">@lang('doctor.visiting_time')</div>
                        <div class="patient-box">{{ $reservation->time }}</div>
                    </div>
                    <div class="right-m-1">
                        <div class="patient-box">@lang('doctor.visiting_date')</div>
                        <div class="patient-box">{{ $reservation->date->toDateString() }}</div>
                    </div>
                </div>
                <div class="flex-m-2">
                    <div class="right-m-1">
                        <div class="patient-box">@lang('doctor.age/gender')</div>
                        <div class="patient-box">
                            {{ $reservation->age . ' / ' . __('doctor.' . $reservation->gender) }}
                        </div>
                    </div>
                    <div class="right-m-1">
                        <div class="patient-box">@lang('site.serial_number')</div>
                        <div class="patient-box">{{ $reservation->id }}</div>
                    </div>
                </div>

                @foreach ($reservation->labSubcategoryReservationHasMany as $test)
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


                <div class="mt-3 ">
                    <h6 class="fontBold mainColor mb-1 font14 color-main font_bold mb-1">
                        @lang('doctor.report')
                    </h6>
                    <p class="m-para">
                        {{ $reservation->lab_report }}
                    </p>
                </div>
                <div class="modal-3-img-con mt-4">
                    <div class="row">
                        @foreach ($reservation->images as $image)
                            <div class="col-lg-3 col-md-6 col-12 mt-3 mb-2">
                                <div class="img-box-s">
                                    <img src="{{ $image->image }}" alt="" />
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
{{-- <!-- Modal 3 -->
<div class="modal fade" id="viewResultModal" tabindex="-1" aria-labelledby="viewResultModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-spe">
        <div class="modal-content">
            <div class="modal-header no-border-bottom close-modal">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body no-border-bottom modal2-spe">
                <h5 class="font_bold text-center mb-3">مختبر الشفاء</h5>
                <div class="modal3-title">
                    الطبيب المرسل:
                    <span>محمد اشرف</span>
                </div>
                <div class="modal-big-tit text-center">نتيجة الاختبار</div>
                <div class="flex-m-1">
                    <div class="right-m-1">
                        <div class="patient-box">اسم المريض</div>
                        <div class="patient-box">اسم المريض</div>
                    </div>
                    <div class="right-m-1">
                        <div class="patient-box">اسم المريض</div>
                        <div class="patient-box">اسم المريض</div>
                    </div>
                    <div class="right-m-1">
                        <div class="patient-box">اسم المريض</div>
                        <div class="patient-box">اسم المريض</div>
                    </div>
                </div>
                <div class="flex-m-2">
                    <div class="right-m-1">
                        <div class="patient-box">اسم المريض</div>
                        <div class="patient-box">اسم المريض</div>
                    </div>
                    <div class="right-m-1">
                        <div class="patient-box">اسم المريض</div>
                        <div class="patient-box">اسم المريض</div>
                    </div>
                </div>
                <div class="flex-m-3">
                    <div class="right-n-1">
                        <div class="patient-box">units</div>
                        <div class="patient-box-spe">10*3mk</div>
                    </div>
                    <div class="right-n-1">
                        <div class="right-n-1">
                            <div class="patient-box">units</div>
                            <div class="patient-box-spe">10*3mk</div>
                        </div>
                    </div>
                    <div class="right-n-1">
                        <div class="right-n-1">
                            <div class="patient-box">units</div>
                            <div class="patient-box-spe">10*3mk</div>
                        </div>
                    </div>
                    <div class="right-n-1">
                        <div class="right-n-1">
                            <div class="patient-box">units</div>
                            <div class="patient-box-spe">10*3mk</div>
                        </div>
                    </div>
                </div>
                <div class="flex-m-3">
                    <div class="right-n-1">
                        <div class="patient-box">units</div>
                        <div class="patient-box-spe">10*3mk</div>
                    </div>
                    <div class="right-n-1">
                        <div class="right-n-1">
                            <div class="patient-box">units</div>
                            <div class="patient-box-spe">10*3mk</div>
                        </div>
                    </div>
                    <div class="right-n-1">
                        <div class="right-n-1">
                            <div class="patient-box">units</div>
                            <div class="patient-box-spe">10*3mk</div>
                        </div>
                    </div>
                    <div class="right-n-1">
                        <div class="right-n-1">
                            <div class="patient-box">units</div>
                            <div class="patient-box-spe">10*3mk</div>
                        </div>
                    </div>
                </div>
                <div class="mt-3 en-dir">
                    <h6 class="fontBold mainColor mb-1 font14 color-main font_bold mb-1">
                        report
                    </h6>
                    <p class="m-para">
                        Contrary to popular belief, Lorem Ipsum is not simply random
                        text. It has roots in a piece of classical Latin literature from
                        45 BC, making it over 2000 years old. Richard McClintock
                    </p>
                </div>
                <div class="modal-3-img-con mt-4">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="img-box-s">
                                <img src="imgs/NoPath - Copy (84).png" alt="" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="img-box-s">
                                <img src="imgs/NoPath - Copy (84).png" alt="" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="img-box-s">
                                <img src="imgs/NoPath - Copy (84).png" alt="" />
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 col-12">
                            <div class="img-box-s">
                                <img src="imgs/NoPath - Copy (84).png" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
