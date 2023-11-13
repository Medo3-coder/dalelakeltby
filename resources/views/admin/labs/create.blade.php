@extends('admin.layout.master')
{{-- extra css files --}}
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/lab.css') }}">
    @livewireStyles
    <style>
        .branch_images_image {
            position: relative;
            cursor: pointer;
        }

        .branch_images_image i {
            color: #1d1a1a;
            font-size: 30px;
            position: absolute;
            left: 50%;
            top:50%;
            transform: translate(-50%,-50%)
        }
        .branch_images_image:hover:hover i{
            color: #f00
        }
    </style>
@endsection

{{-- extra css files --}}

@section('content')
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header ">
                        <h4 class="card-title mb-2">{{ __('admin.add') . ' ' . __('admin.lab') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data" class="store form-horizontal"
                                novalidate>
                                @csrf


                                <livewire:admin.lab.create-lab />


                                {{--  <div class="form-body">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-center mt-3">
                                            <button type="submit"
                                                class="btn btn-primary mr-1 mb-1 submit_button">{{ __('admin.add') }}</button>
                                            <a href="{{ url()->previous() }}" type="reset"
                                                class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
                                        </div>
                                    </div>
                                </div>  --}}
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/forms/validation/form-validation.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>

    @livewireScripts

    {{-- show selected image script --}}
    @include('admin.shared.addImage')
    {{-- show selected image script --}}

    {{-- submit add form script --}}
    @include('admin.shared.submitAddForm')
    {{-- submit add form script --}}

    @include('admin.partials.map', ['draggable' => true])



    {{--  <script>
        // function addTime() {
        $(document).on('click', '.add-time', function() {

            var clone_div = $('#clone_div').clone();
            clone_div.find('input').val(null);
            $('.time-cont').append(clone_div);
        })

        $(document).on('change', '.days_select', function() {
            var value = $(this).val()
            var current_select = $(this)
            current_select.removeClass('days_select_each')
            $(".days_select_each").each(function(i) {
                if ($(this).val() == value) {
                    toastr.error("{!! __('admin.used_before') !!}");
                    current_select.val(null)


                }
            });
            current_select.addClass('days_select_each')
        });

        function removeTime(rmButton) {
            $(rmButton).parents(".times-cont").remove();
        }
    </script>  --}}

    {{--  <!--swich radio1-->
    <script>
        $(".radio-spe").change(function(e) {
            $(".show-spe").each(function() {
                if ($(this).attr("id") === $(e.target).parent().data('radio')) {
                    $(this).toggleClass('show-mm');
                }
            });
        });
    </script>

    <!--catch all checked element and added to array -->
    <script>
        let array = [];
        $('.default-row [type="checkbox"]').on('change', function() {
            array = [];
            $(".default-row [type='checkbox']:checked").each(function() {
                array.push($(this).val());
            });
            console.log(array);
        });
    </script>



    <script>
        let allselects = document.querySelectorAll(".another-sh-select");
        // let alldivs = document.querySelectorAll(".show-another");
        for (let i = 0; i < allselects.length; i++) {
            allselects[i].addEventListener("change", function() {
                if (
                    this.options[this.selectedIndex].dataset.another === "another-sh-sp"
                ) {
                    this.parentElement.nextElementSibling.nextElementSibling.style.display =
                        "block";
                }
            });
        }
    </script>  --}}
@endsection
