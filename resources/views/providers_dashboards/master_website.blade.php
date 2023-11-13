@extends('providers_dashboards.layouts.site.site_master')

@section('content')
    <section class="content" id="goheadspe">
        <!--start landing-->
        <div class="landing" id="gomain">
            <div class="container">
                <div class="row">
                    <div class="col-md-6 col-12">
                        <div class="landing-right">
                            <div class="landing-title">
                                <h2>{{ __('admin.platform_' . request()->segment(1)) }}</h2>
                            </div>

                            @switch(request()->segment(1))
                                @case('doctor')
                                    <h2 class="landing-join">{{ __('admin.join_us_now') }}</h2>
                                @break

                                @case('pharmacy')
                                    <h2 class="landing-join">{{ __('admin.shopping_now') }}</h2>
                                @break
                            @endswitch
                            <h2 class="landing-join">{{ $settings[request()->segment(1) . '_header_title_' . lang()] }}
                            </h2>
                            <p>
                                {{ $settings[request()->segment(1) . '_header_description_' . lang()] }}
                            </p>
                            <div class="downloads">
                                <a href="{{ $settings['google_play_link'] }}"><img
                                        src="{{ asset('site/imgs/Group 4460.png') }}" alt="" /></a>
                                <a href="{{ $settings['app_store_link'] }}"><img
                                        src="{{ asset('site/imgs/Group 4461.png') }}" alt="" /></a>
                                <a href="{{ $settings['platform_explain_link'] }}"><img
                                        src="{{ asset('site/imgs/Group 83411.png') }}" alt="" /></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-12">
                        <div class="landing-left text-center">
                            <img src="{{ asset('site/imgs/Component 3 – 4.png') }}" alt="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end landing-->
        <!--start specials-->
        @if (count($features) > 0)
            <div class="specials" id="gospecial">
                <div class="container">
                    <h2 class="text-center">{{ __('admin.dalelak_features') }}</h2>
                    <p class="text-center title-p">
                        {{ __('admin.dalelak_features_description') }}
                    </p>
                    <div class="row">

                        @foreach ($features as $feature)
                            <div class="col-lg-3 col-md-4 col-12">
                                <div class="spe-box">
                                    <img style="max-width:50px" src="{{ $feature->image }}" alt="" />
                                    <h5>{{ $feature->title }}</h5>
                                    <p>
                                        {{ $feature->description }}
                                    </p>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        @endif
        <!--end specials-->
        <!--start best doctors-->
        <div class="best-doctors">
            <div class="container">
                <div class="row">
                    <div class="col-md-9 col-12">
                        <h2 class="color-main">
                            {{ __('admin.most_famous_doctors_title') }}
                        </h2>
                        <p>
                            {{ $settings['most_famous_doctors_text_' . lang()] }}
                        </p>
                    </div>
                    <div class="col-md-3 col-12">
                        <img class="img-fluid" src="{{ asset('site/imgs/PngItem_1115368.png') }}" alt="" />
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                @php
                    $counter = 0;
                @endphp
                @if (request()->segment(1) !== 'doctor')
                    @php
                        $counter++;
                    @endphp
                    <div class="col-md-6 col-12">
                        <div class="best-box">
                            <div class="best-box-right">
                                <h2>{{ __('admin.join_us_as_doctor') }}</h2>
                                <p>
                                    {{ $settings['join_doctor_text_' . lang()] }}
                                </p>
                                <a href="{{ route('doctor.site') }}" class="up">{{ __('admin.show_more') }} <i
                                        class="fa-solid fa-arrow-left-long"></i></a>
                            </div>
                            <div class="best-box-left">
                                <img src="{{ asset('site/imgs/Group 83159.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                @endif
                @if (request()->segment(1) !== 'store')
                    @php
                        $counter++;
                    @endphp
                    <div class="col-md-6 col-12">
                        <div class="best-box">
                            <div class="best-box-right">
                                <h2>{{ __('admin.join_us_as_store') }}</h2>
                                <p>
                                    {{ $settings['join_store_text_' . lang()] }}
                                </p>
                                <a href="{{ route('store.site') }}" class="up">{{ __('admin.show_more') }} <i
                                        class="fa-solid fa-arrow-left-long"></i></a>
                            </div>
                            <div class="best-box-left">
                                <img src="{{ asset('site/imgs/Group 83159.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                @endif
                @if (request()->segment(1) !== 'lab')
                    @php
                        $counter++;
                    @endphp
                    <div class="col-md-{{ $counter == 3 ? 12 : 6 }} col-12">
                        <div class="best-box">
                            <div class="best-box-right">
                                <h2>{{ __('admin.join_us_as_lab') }}</h2>
                                <p>
                                    {{ $settings['join_lab_text_' . lang()] }}
                                </p>
                                <a href="{{ route('lab.site') }}" class="up">{{ __('admin.show_more') }} <i
                                        class="fa-solid fa-arrow-left-long"></i></a>
                            </div>
                            <div class="best-box-left">
                                <img src="{{ asset('site/imgs/Group 83159.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                @endif
                @if (request()->segment(1) !== 'pharmacy')
                    @php
                        $counter++;
                    @endphp
                    <div class="col-md-{{ $counter == 3 ? 12 : 6 }} col-12">
                        <div class="best-box">
                            <div class="best-box-right">
                                <h2>{{ __('admin.join_us_as_pharmacy') }}</h2>
                                <p>
                                    {{ $settings['join_pharmacy_text_' . lang()] }}
                                </p>
                                <a href="{{ route('pharmacy.site') }}" class="up">{{ __('admin.show_more') }} <i
                                        class="fa-solid fa-arrow-left-long"></i></a>
                            </div>
                            <div class="best-box-left">
                                <img src="{{ asset('site/imgs/Group 83159.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        <!--end best doctors-->
        @if (count($appPages) > 0)
            <!--start App pages-->
            <div class="app-section">
                <div class="container">
                    <h2 class="text-center">{{ __('admin.app_pages') }}</h2>
                    <p class="text-center title-p">
                        {{ __('admin.app_pages_description') }}
                    </p>
                    <div class="slider-spe text-center">
                        <div class="slider-pad">
                            <div class="back-ph">
                                <img src="{{ asset('site/imgs/backsw(1).png') }}" alt="" />
                            </div>
                            <div class="owl-carousel owl-theme">

                                @foreach ($appPages as $appPage)
                                    <div class="item">
                                        <img src="{{ $appPage->image }}" alt="" />
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end App pages-->
        @endif
        <!--start statistics-->
        <div class="statictics">
            <div class="container">
                <h2 class="text-center">{{ __('site.app_statistics') }}</h2>
                <p class="text-center title-p">
                    {{ __('admin.app_pages_description') }}
                </p>
                <div class="stats-boxes text-center">
                    <div class="row">
                        <div class="col-lg-3 col-md-4 col-6 m-top-20">
                            <div class="goal-flex">
                                <div class="stats-rel-num" data-goal="{{$usersCount}}">0</div>
                                <span>+</span>
                            </div>
                            <div class="stats-num">{{ __('site.customers_number') }}</div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-6 m-top-20">
                            <div class="goal-flex">
                                <div class="stats-rel-num" data-goal="{{$binifitCount}}">0</div>
                                <span>+</span>
                            </div>
                            <div class="stats-num">{{ __('site.the_number_of_beneficiaries') }}</div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-6 m-top-20">
                            <div class="goal-flex">
                                <div class="stats-rel-num" data-goal="{{$doctorsCount}}">0</div>
                                <span>+</span>
                            </div>
                            <div class="stats-num">{{ __('site.registered_physicians') }}</div>
                        </div>
                        <div class="col-lg-3 col-md-4 col-6 m-top-20">
                            <div class="goal-flex">
                                {{-- <div class="stats-rel-num" data-goal="{{$settings['downloads_count']}}">0</div> --}}
                                <div class="stats-rel-num" data-goal="{{$usersCount}}">0</div>
                                <span>+</span>
                            </div>
                            <div class="stats-num">{{ __('site.downloads') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--end statistics-->
    </section>
@endsection
