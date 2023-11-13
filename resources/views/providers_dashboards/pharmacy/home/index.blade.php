@extends('providers_dashboards.layouts.dashboards.master')

@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading">
                <h6>{{ __('doctor.dashboard') }}</h6>
                <p>{{ __('doctor.welcome_back_mr', ['name' => auth('pharmacy')->user()->name]) }}</p>
            </div>
            <div class="home-boxes">
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">
                                    {{ provider('pharmacy')->orders()->where(['status' => 'pending'])->count() }}</div>
                                <div class="home-title">@lang('site.new_orders')</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">
                                    {{ provider('pharmacy')->orders()->where('status', 'accepted')->count() }}
                                </div>
                                <div class="home-title">@lang('site.in_progress_orders')</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">
                                    {{ provider('pharmacy')->orders()->whereIn('status', ['canceled', 'rejected'])->count() }}
                                </div>
                                <div class="home-title">@lang('site.finished_orders')</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">{{ provider('pharmacy')->orders()->count() }}</div>
                                <div class="home-title">@lang('site.total_of_orders')</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @if (count($stores) > 0)
                <div class="d-flex justify-content-between align-items-center">
                    <div class="side-heading mt-4">
                        <h6>@lang('localize.most_popular_stores')</h6>
                    </div>
                    <a class="gray-m" href="{{route('pharmacy.stores.index')}}">@lang('localize.more_of_stores') <i
                            class="fa-solid fa-chevron-left"></i></a>
                </div>
                <div class="devices-boxs mb-3">
                    <div class="row">
                        @foreach ($stores as $store)
                            <div class="col-lg-4 col-md-6 col-12">
                                <div class="device-box text-center">
                                    <img class="border-radious-spe" src="{{ $store->image }}" alt="" />
                                    <div class="card_foot card-f-spe">
                                        <h6 class="text-center font_bold no-border-bottom">{{ $store->name }}</h6>
                                        <div class="phar-titles white-fire mb-1">
                                            @lang('localize.address') : {{ $store->firstBranch()->address }}
                                        </div>
                                        <div class="phar-titles white-fire mb-1">
                                            @lang('localize.email') : {{ $store->email }}
                                        </div>
                                        <div class="phar-titles white-fire mb-1">
                                            @lang('localize.phone_number') : {{ $store->phone }}
                                        </div>
                                        <div class="flex-device justify-content-center">
                                            <a href="{{ route('pharmacy.stores.details', $store->id) }}"
                                                class="link-device up">@lang('localize.more')</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
        <!-- Start Trainer Section -->
        <div class="container">
            <section class="trainer">
                <div class="cards">
                    @if (count($products) > 0)
                        <div class="card right">
                            <h1 class="heading">@lang('translation.most_requested_drugs')</h1>
                            <div class="courses">

                                @foreach ($products as $key => $product)
                                    <a href="{{ route('pharmacy.stores.details', optional($product->store)->id) }}">
                                        <div class="course">
                                            <div class="flex-course-m">

                                                <div class="num"># {{ $key + 1 }}</div>
                                                <div class="content">
                                                    <div class="img">
                                                        <img src="{{ $product->image }}" alt="" />
                                                    </div>
                                                    <div class="info">
                                                        <h3>{{ $product->store->name }}</h3>
                                                        <p>
                                                            {{ $product->name }}
                                                        </p>
                                                        <div class="address-spe">
                                                            {{ $product->store->branches()->first()->address }}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- <a href="#"></a> -->

                                            <i class="fa-solid fa-angle-left icon-right"></i>
                                        </div>
                                    </a>
                                @endforeach

                            </div>
                        </div>
                    @endif


                    @if (count($offers) > 0)
                        <div class="card right">
                            <h1 class="heading">@lang('localize.popular_offers')</h1>

                            @foreach ($offers as $key => $offer)
                                <div class="courses">

                                    <a href="{{ route('pharmacy.stores.details', optional($offer->store)->id) }}">
                                        <div class="course">
                                            <div class="flex-course-m">
                                                <div class="num"># {{ $key + 1 }}</div>
                                                <div class="content">
                                                    <div class="img">
                                                        <img src="{{ $offer->image }}" alt="" />
                                                    </div>
                                                    <div class="info">
                                                        <h3>{{ $offer->store->name }}</h3>
                                                        <p>
                                                            {{ $offer->name }}
                                                        </p>
                                                        <div class="address-spe">
                                                            {{ $offer->store->branches()->first()->address }}
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                            <!-- <a href="#"></a> -->

                                            <i class="fa-solid fa-angle-left icon-right"></i>
                                        </div>
                                    </a>

                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        </div>
    </main>
@endsection


@push('js')
@endpush
