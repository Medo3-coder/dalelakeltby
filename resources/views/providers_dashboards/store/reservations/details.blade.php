@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
@endpush
@section('content')

 <main class="main-sec" id="main">
      <div class="container">
        <div class="table-top-book">
          <div class="side-heading">
            
            <h6>@lang('site.control_panel')</h6>
            <div class="links-top-to">
              <a href="booking.html">@lang('site.reservations')</a> /
              <a href="accepted-offers.html">@lang('site.accepted_reservations')</a> /
              <span class="color-main">@lang('site.reservation_details')</span>
            </div>
          </div>
          <a href="result.html" class="test-result up">
            <i class="fa-solid fa-calendar-days"></i>@lang('site.reservation_results')
          </a>
        </div>
        <div class="card-white righ-left-p-0">
          <h6 class="row-tab-m">@lang('site.reservation_details')</h6>
          <div class="card-white-button">
            <div class="row1">
              <div class="row-right">
                <div class="name-card color-gray">@lang('site.name')</div>
                <div class="name-card">{{$reservation->user->name}}</div>
              </div>
              <div class="row-left">
                <div class="name-card color-gray">@lang('site.reservation_time')</div>
                <div class="name-card">{{$reservation->date->format('H:i A')}}</div>
              </div>
            </div>
            <div class="row1">
              <div class="row-right">
                <div class="name-card color-gray">@lang('site.age')</div>
                <div class="name-card">{{$reservation->reservation_for  == 'family' ? $reservation->age : $reservation->user->age}}</div>
              </div>
              <div class="row-left">
                <div class="name-card color-gray">@lang('site.reservation_date')</div>
                <div class="name-card">{{$reservation->date->format('d-m-Y')}}</div>
              </div>
            </div>
            <div class="row1">
              <div class="row-right">
                <div class="name-card color-gray">@lang('site.blood_type')</div>
                <div class="name-card">{{$reservation->reservation_for  == 'family' ? $reservation->bloodType->name : $reservation->user->bloodType->name}}</div>
              </div>
              <div class="row-left">
                <div class="name-card color-gray">@lang('site.transfer_from_doctor')</div>
                <div class="name-card">{{$reservation->doctor_id != null ? __('site.yes') : __('site.no')}}</div>
              </div>
            </div>
            <div class="row1">
              <div class="row-right">
                <div class="name-card color-gray">الاسم</div>
                <div class="name-card">محمد اشرف</div>
              </div>
              <div class="row-left">
                <div class="name-card color-gray">ميعاد الحجز</div>
                <div class="name-card">05:00 pm</div>
              </div>
            </div>
            <div class="row1">
              <div class="row-right">
                <div class="name-card color-gray">الاسم</div>
                <div class="name-card">محمد اشرف</div>
              </div>
              <div class="row-left">
                <div class="name-card color-gray">ميعاد الحجز</div>
                <div class="name-card">05:00 pm</div>
              </div>
            </div>
            <div class="row1">
              <div class="row-right">
                <div class="name-card color-gray">الاسم</div>
                <div class="name-card">محمد اشرف</div>
              </div>
              <div class="row-left">
                <div class="name-card color-gray">ميعاد الحجز</div>
                <div class="name-card">05:00 pm</div>
              </div>
            </div>
          </div>
        </div>
        <div class="card-white">
          <h5>الاختبار المطلوب</h5>
          <p>wbc</p>
          <h5>الاختبار المطلوب</h5>
          <p>هذا النص هو مثال لنص يمكن ان يستبدل في نفس المساحة</p>
        </div>
        <div class="card-white text-center">
          <div class="top-buttom">
            <h5>الاختبار المطلوب</h5>
            <a
              href=""
              class="test-result-spe up"
              data-toggle="modal"
              data-target="#exampleModal"
            >
              <i class="fa-solid fa-calendar-days"></i>
              تعديدل النتيجة
            </a>
          </div>
          <a
            href="#"
            class="test-result-big up"
            data-toggle="modal"
            data-target="#exampleModal3"
          >
            <i class="fa-solid fa-book-open"></i>
            مطالعة نتيجة التحليل
          </a>
        </div>
      </div>
    </main>
    
    <!-- Modal 1 -->
    <div
      class="modal fade"
      id="exampleModal"
      tabindex="-1"
      aria-labelledby="exampleModalLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-spe">
        <div class="modal-content">
          <div class="modal-header no-border-bottom">
            <h5 class="modal-title font_bold" id="exampleModalLabel">
              تعديل النتيجة
            </h5>
          </div>
          <div class="modal-body no-border-bottom modal1-spe">
            <div class="personal-data">
              <div class="personal-row">
                <div class="personal-row-part">
                  اسم المريض : <span>محمد اشرف</span>
                </div>
                <div class="personal-row-part">
                  عمر المريض : <span>30</span>
                </div>
                <div class="personal-row-part">
                  فصيلة الدم : <span>b+</span>
                </div>
              </div>
              <div class="personal-row">
                <div class="personal-row-part">
                  اسم المريض : <span>محمد اشرف</span>
                </div>
                <div class="personal-row-part">
                  عمر المريض : <span>30</span>
                </div>
                <div class="personal-row-part">
                  فصيلة الدم : <span>b+</span>
                </div>
              </div>
            </div>
            <form action="" class="form-modal1">
              <div class="add-iff">
                <div class="mb-3 main-inp-cont">
                  <h6 class="fontBold mainColor font14">اسم الاختبار</h6>
                  <div class="form__label">
                    <input
                      class="default_input"
                      type="text"
                      required=""
                      placeholder="الرجاء ادخال اسم الاختبار"
                    />
                    <label class="float__label" for=""
                      >الرجاء ادخال اسم الاختبار</label
                    >
                  </div>
                </div>
                <div class="mb-3 main-inp-cont">
                  <h6 class="fontBold mainColor font14">النتيجة</h6>
                  <div class="form__label">
                    <input
                      class="default_input"
                      type="text"
                      required=""
                      placeholder="الرجاء ادخال النتيجة"
                    />
                    <label class="float__label" for=""
                      >الرجاء ادخال النتيجة</label
                    >
                  </div>
                </div>
              </div>
              <div class="work-plus-icon">
                <div class="plus-add">اضافة جديد</div>
              </div>
              <div class="mb-3 main-inp-cont">
                <h6 class="fontBold mainColor font14">ادخل صورة او ملف</h6>
                <div class="form__label">
                  <label for="filesNext4_input" class="apload-img-reg">
                    <input
                      type="file"
                      hidden
                      id="filesNext4_input"
                      class="heddenUploud files-input"
                      name="filesNext4[]"
                      data-input="filesNext4"
                    />
                    <div class="add-photo">
                      <i class="fa-solid fa-images"></i>
                    </div>
                    <div class="img-apload-title">
                      تستطيع ادخال الصورة او الهوية
                    </div>
                  </label>
                </div>
                <div class="uploaded__area" id="filesNext4_cont"></div>
              </div>
              <div class="mt-3 main-inp-cont">
                <h6 class="fontBold mainColor mb-1 font14">التقرير</h6>
                <label class="form__label">
                  <textarea
                    class="default_input"
                    type="text"
                    required=""
                    placeholder="اكتب التقرير"
                  ></textarea>
                  <span class="float__label">من فضلك اكتب التقرير</span>
                </label>
              </div>
              <div class="d-flex align-items-center justify-content-center">
                <button
                  type="button"
                  class="submit up mt-3"
                  data-toggle="modal"
                  data-target="#staticBackdrop"
                  data-dismiss="modal"
                >
                  حفظ وطباعة
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 2 -->
    <div
      class="modal fade"
      id="staticBackdrop"
      tabindex="-1"
      aria-labelledby="staticBackdropLabel"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-spe2">
        <div class="modal-content">
          <div class="modal-body no-border-bottom modal2-spe text-center">
            <img src="imgs/7717-successful.gif" alt="" />
            <div class="font_bold don-t">تم تعديل النتيجة بنجاح</div>
            <div class="d-flex align-items-center justify-content-center">
              <button type="button" class="submit" data-dismiss="modal">
                تم
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modal 3 -->
    <div
      class="modal fade"
      id="exampleModal3"
      tabindex="-1"
      aria-labelledby="exampleModal3Label"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-dialog-spe">
        <div class="modal-content">
          <div class="modal-header no-border-bottom close-modal">
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
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
              <h6
                class="fontBold mainColor mb-1 font14 color-main font_bold mb-1"
              >
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
    </div>
@endsection
@push('js')
    
@endpush
