@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/extensions/toastr.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css')}}">
@endpush
@section('content')

    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading">
                <h6>@lang('site.control_panel')</h6>
                <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('store')->user()->name])</p>
            </div>
{{--            @dd(authUser('store'))--}}
            <div class="home-boxes">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">

                                <div class="home-num">
                                    {{ $ordersPendingCount }}
                                </div>
                                <div class="home-title">{{ __('store.pending orders') }}</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>

                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">
                                    {{ $ordersAcceptedCount }}
                                </div>
                                <div class="home-title">{{ __('store.accepted orders') }}</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">
                                    {{ $ordersPreparedCount }}
                                </div>
                                <div class="home-title">{{ __('store.prepared orders') }}</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">
                                    {{ $ordersRejectedCount }}
                                </div>
                                <div class="home-title">{{ __('store.rejected orders') }}</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-6 col-12">
                        <div class="home-box">
                            <div class="box_right">
                                <div class="home-num">
                                    {{ $ordersCount }}
                                </div>
                                <div class="home-title">{{ __('store.all orders') }}</div>
                            </div>
                            <div class="box-left">
                                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between">
                <div class="side-heading mt-4">
                    <h6>{{ __('store.Incoming requests') }}</h6>
                    <p>{{ __('store.You can follow all requests received from here') }}</p>
                </div>
                <a href="{{ route('store.orders.pending') }}" class="alll text-secondary mt-1">{{ __('store.All requests') }}</a>
            </div>
            <div class="overflowx_auto mb-3 padding-b">
                <table class="table text-center" style="width: 100%">
                    <thead class="table-head">
                    <tr>
                        <th class="font10">@lang('site.serial_number')</th>
                        <th class="font10">{{ __('store.order number') }}</th>
                        <th class="font10">{{ __('store.customer name') }}</th>
                        <th class="font10">{{ __('store.customer address') }}</th>
                        <th class="font10">{{ __('store.The date of application') }}</th>
                        <th class="font10"></th>
                    </tr>
                    </thead>
                    <tbody data-class-name="table-body">
                    @foreach($orders as $key => $order)
                        <tr>
                            <td class="font12">{{ '#' . $key + 1 }}</td>

                            <td>
                                <span class="d-flex justify-content-center align-items-center">{{ $order->order_num }}</span>
                            </td>
                            <td>
                                <span class="d-flex justify-content-center align-items-center">{{ getUser($order)->name }}</span>
                            </td>

                            <td>
                                <span class="d-flex justify-content-center align-items-center">{{ \Illuminate\Support\Str::limit($order->address, 50) }}</span>
                            </td>

                            <td>
                                <span class="d-flex justify-content-center align-items-center">{{ Carbon\Carbon::parse($order->created_at)->translatedFormat('j F Y') }}</span>
                            </td>


                            <td>
                                <a href="{{ route('store.orders.show', $order['id']) }}" class="font_bold color-main">
                                    <span class="">{{ __('store.Order details') }}</span>
                                </a>
                            </td>






                        </tr>
                    @endforeach




                    </tbody>

                    @if(count($orders) == 0)
                        @include('shared.empity')
                    @endif
                </table>

            </div>
        </div>


        <!-- Start Trainer Section -->
        <div class="container">
            <section class="trainer">
                <div class="cards">
                    <div class="card right">
                        <h1 class="heading">{{ __('store.Best selling drugs') }}</h1>
                        <div class="courses">
                            <div class="repo-spe-f">
                                @forelse($products as $product)
                                    <a href="{{ route('store.products.show', $product->id) }}">
                                        <div class="course">
                                            <div class="num">#{{ $i++ }}</div>
                                            <div class="content">
                                                <div class="img">
                                                    <img
                                                            src="{{ $product->image }}"
                                                            alt=""
                                                    />
                                                </div>
                                                <div class="info">
                                                    <h3>{{ $product->name }}</h3>
                                                    <p>
                                                        {{ $product->desc }}
                                                    </p>
                                                    <div class="address-spe">
                                                        {{ __('store.Recipe done', ['num'=>$product->counter]) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <i class="fa-solid fa-angle-left icon-right"></i>
                                        </div>
                                    </a>
                                @empty

                                @endforelse




                            </div>
                            @if(count($products) == 0)
                                @include('shared.empity')
                            @endif

                        </div>
                    </div>
                </div>
            </section>
        </div>

    </main>

    <!-- Modal 1 -->
    <div class="modal fade" id="staticBackdrop" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe">
                    <h4 class="font_bold">@lang('site.refuse_order_reason')</h4>
                    <form action="{{ url('lab/refuse-reservation') }}" method="POST" enctype="multipart/form-data"
                        class="form">
                        @csrf
                        <div class="mt-3 main-inp-cont">
                            <h6 class="fontBold mainColor mb-1 font14">@lang('site.message_content')</h6>
                            <label class="form__label mb-4">
                                <input type="hidden" name="reservation_id" id="reservation_id">
                                <textarea class="default_input" type="text" name="cancel_reason" required placeholder="@lang('site.write_message')"></textarea>
                                <span class="float__label">@lang('site.write_message')</span>
                            </label>
                        </div>
                        <div class="d-flex align-items-center justify-content-center">
                            <button type="submit" class="submit submit_button" >
                                @lang('site.confirm')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal 2 -->
    <div class="modal fade" id="staticBackdrop2" tabindex="-1" aria-labelledby="staticBackdrop2Label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{asset('dashboard/imgs/7717-successful.gif')}}" alt="" />
                    <div class="font_bold don-t">
                        @lang('site.order_accepted_follow')
                    </div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">
                            @lang('site.done')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="staticBackdrop3" tabindex="-1" aria-labelledby="staticBackdrop2Label"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe text-center">
                    <img src="{{asset('dashboard/imgs/7717-successful.gif')}}" alt="" />
                    <div class="font_bold don-t">@lang('site.order_refused_successfully')</div>
                    <div class="d-flex align-items-center justify-content-center">
                        <button type="button" class="submit" data-dismiss="modal">
                            @lang('site.done')
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script src="{{asset('admin/app-assets/vendors/js/extensions/toastr.min.js')}}"></script>

    <script>
        $(document).on('click', '.refuse_order', function() {
            $('#reservation_id').val($(this).data('reservation_id'))
        });
    </script>

    <script>
        $(document).on('click', '.accept_order', function() {
            var url = $(this).data('url')
            $.ajax({
                url: url,
                method: 'get',
                data: {},
                dataType: 'json',
                success: (response) =>  {
                    if (response.status != 'success') {
                        toastr.error(response.msg)
                    }else{
                        $('#staticBackdrop2').modal('show');
                        setTimeout(() => {
                            window.location.reload() 
                        }, 2000);
                    }
                },
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('submit', '.form', function(e) {
                var old_content =  $(".submit_button").html()
                e.preventDefault();
                var url = $(this).attr('action')
                $.ajax({
                    url: url,
                    method: 'post',
                    data: new FormData($(this)[0]),
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        old_content =  $(".submit_button").html()
                        $(".submit_button").html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').attr('disable', true)
                    },
                    success: (response) =>  {
                        $(".submit_button").html(old_content).attr('disable', false)
                        if (response.status != 'success') {
                            toastr.error(response.msg)
                        }else{
                            $('#staticBackdrop').modal('hide');
                            $('#staticBackdrop3').modal('show');
                            setTimeout(() => {
                               window.location.reload() 
                            }, 2000);
                        }
                    },
                });

            });
        });
    </script>
    {{-- staticBackdrop2 --}}
@endpush
