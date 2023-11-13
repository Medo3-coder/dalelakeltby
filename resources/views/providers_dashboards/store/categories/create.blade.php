@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endpush
@section('content')

    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading">
                <h6>{{ __('store.Add a new section for products') }}</h6>
                <div class="links-top-to">
                    <a href="{{ route('store.categories') }}">{{ __('store.Products categories') }}</a>  /
                    <span class="color-main">{{ __('store.Add a new section for products') }}</span>
                </div>
            </div>
            <form action="{{ route('store.categories.store') }}" id="form" method="POST" enctype="multipart/form-data" class="form">
                @csrf
                <div class="card-ins">
                    <div class="card-white">
                        <h4 class="font_bold mb-4 spe-border">{{ __('store.New section data') }}</h4>

                        @foreach (languages() as $lang)
                            <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.category_name_' . $lang) }}</h6>
                            <div class="form__label">
                                <input
                                        class="default_input"
                                        type="text"
                                        name="name[{{ $lang }}]"
                                        placeholder="{{ __('site.write') .  ' ' . __('store.category_name_' . $lang) }}"
                                />
                                <label class="float__label" for=""
                                >{{ __('store.write') . ' ' . __('store.category_name_' . $lang) }}</label
                                >
                            </div>
                            <div class="error_show error_name[{{ $lang }}]"> </div>
                        </div>
                        @endforeach



                    </div>
                </div>

                <div class="col-12">
                    <button type="submit" id="submit-button" class="submit up mt-3 mr-2 text-center submit-button">{{ __('store.Add confirmation') }}</button>
                </div>
            </form>
        </div>


    </main>

@endsection
@push('js')
    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>

    @include('providers_dashboards.store.includes.js.formAjax')

@endpush
