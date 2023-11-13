@extends('providers_dashboards.layouts.dashboards.master')

@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="card-white spe-pad">
                <h5 class="font_bold mb-4">{{ __('doctor.edit_medicine') }}</h5>
                <form class="form" method="POST" action="{{ route('doctor.medicine.update', $medicine->id) }}">
                    @csrf
                    @method('put')

                    <div class="img-cont-spe">
                        <img src="{{ $medicine->image }}" alt="" id="change-profile">
                        <label class="edit-spe" for="img-up"><i class="fa-regular fa-pen-to-square"></i>
                            <input accept="images/*" name="image" onchange="loadFiles(event)" type="file"
                                id="img-up" hidden="">
                        </label>
                    </div>


                    <div class="mb-3 main-inp-cont col-12 col-lg-8">
                        <h6 class="fontBold mainColor font14">{{ __('admin.name') }}</h6>
                        <div class="form__label mt-0">
                            <input class="default_input" name="name" value="{{ $medicine->name }}" type="text"
                                required="" placeholder="{{ __('admin.please_enter') }} {{ __('admin.name') }}" />
                            <label class="float__label" for="">{{ __('admin.please_enter') }} {{ __('admin.name') }}
                            </label>
                        </div>
                    </div>
                    <div class="mb-3 main-inp-cont col-12 col-lg-8">
                        <h6 class="fontBold mainColor font14">{{ __('admin.type') }}</h6>
                        <div class="form__label mt-0">
                            <input class="default_input" name="type" value="{{ $medicine->type }}" type="text"
                                required="" placeholder="{{ __('doctor.please_select_medicine_type') }}" />
                            <label class="float__label"
                                for="">{{ __('doctor.please_select_medicine_type') }}</label>
                        </div>
                    </div>
                    <button class="submit submit-button wid-60 up mt-5">{{ __('admin.edit') }}</button>
                </form>
            </div>
    </main>
@endsection


@push('js')
    @include('shared.formAjax')
    <script>
        var loadFiles = function(event) {
            var images = document.getElementById("change-profile");
            images.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
@endpush
