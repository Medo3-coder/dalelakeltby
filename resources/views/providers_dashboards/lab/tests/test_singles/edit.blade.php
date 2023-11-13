@extends('providers_dashboards.layouts.dashboards.master')

@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading">
                <h6>@lang('localize.add_test')</h6>
                <div class="links-top-to">
                    <a href="{{ route('lab.medicalTests.tests.index') }}">@lang('localize.tests')</a> /
                    <span class="color-main">@lang('localize.add_new_test')</span>
                </div>
            </div>

            <div class="card-white">
                <h4 class="font_bold mb-4 spe-border">@lang('localize.new_test_data')</h4>
                <form action="{{ route('lab.medicalTests.tests.update', ['id' => $test->id, 'test' => $test->sub_category_lab_id]) }}" method="POST" class="form"
                    data-success="$('#staticBackdrop').modal('show')">
                    @csrf
                    @method('put')

                    <div class="mb-3 main-inp-cont col-12 col-lg-8">
                        <h6 class="fontBold mainColor font14">@lang('localize.name_in_english_test')</h6>
                        <div class="form__label">
                            <input class="default_input" value="{{ $test->name }}" type="text" name="name"
                                placeholder="@lang('localize.pe_name_in_en')" />
                            <label class="float__label" for="">@lang('localize.pe_name_in_en')</label>
                        </div>
                        <div class="error_show error_name"></div>
                    </div>


                    <div class="mb-3 main-inp-cont col-12 col-lg-8">
                        <h6 class="fontBold mainColor font14">@lang('localize.test_price')</h6>
                        <div class="form__label">
                            <input class="default_input" type="text" name="price" value="{{ $test->price }}"
                                placeholder="@lang('localize.pe_test_price')" />
                            <label class="float__label" for="">@lang('localize.pe_test_price')</label>
                        </div>
                        <div class="error_show error_price"></div>
                    </div>


                    <div class="mb-3 main-inp-cont col-12 col-lg-8">
                        <h6 class="fontBold mainColor font14">@lang('localize.range') </h6>
                        <div class="form__label">
                            <input class="default_input" type="text" name="normal_range"
                                value="{{ $test->normal_range }}" placeholder="@lang('localize.pin_the_range')" />
                            <label class="float__label" for="">@lang('localize.pin_the_range')</label>
                        </div>
                        <div class="error_show error_normal_range"></div>

                    </div>
                    <div class="mb-3 main-inp-cont col-12 col-lg-8">
                        <h6 class="fontBold mainColor font14">@lang('localize.unit') </h6>
                        <div class="form__label">
                            <input class="default_input" type="text" name="unit" value="{{ $test->unit }}"
                                placeholder="@lang('localize.pinf_test_unit')" />
                            <label class="float__label" for="">@lang('localize.pinf_test_unit')</label>
                        </div>
                        <div class="error_show error_unit"></div>

                    </div>
                    <div class="col-12">
                        <button class="submit up submit-button mt-3">@lang('admin.update')</button>
                    </div>
                </form>
            </div>
    </main>

    <!-- Modal 2 -->
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{ asset('dashboard/imgs/7717-successful.gif') }}" alt="">
                    <div class="font_bold don-t">@lang('localize.congrat_updated_success')</div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">@lang('localize.confirm')</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    @include('shared.formAjax')

    <script>
        var loadFiles = function(event) {
            var images = document.getElementById("change-profile");
            images.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>

    <script>
        $(document).ready(function() {
            console.log(document.querySelectorAll(".spe-col-act"));
            var sideButtons = document.querySelectorAll(".spe-col-act");
            for (var i = 0; i < sideButtons.length; i++) {
                const a = sideButtons[i].getElementsByTagName("a")[0];
                console.log(a);
                console.log("window", window.location.href);
                console.log("link", a.href);
                if (window.location.href == a.href) {
                    a.classList.add("active-spe-main");
                    break;
                }
            }
        });
    </script>

@endpush
