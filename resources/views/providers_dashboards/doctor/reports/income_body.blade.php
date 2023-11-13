<h5 class="font_bold">{{__('doctor.income_of_month:' ,['month' => __('doctor.month_with_number.' . $month)])}}</h5>
<div class="text-center"><img class="img-pay" src="{{asset('dashboard/imgs/43.png')}}" alt=""></div>
<div class="flex-income">
    <div class="home-box pay-now2">
        <div class="box_right">
            <div class="home-num font_bold font40">{{$reservationsCount}}</div>
            <div class="home-title font20">@lang('doctor.number_of_reservations')</div>
        </div>
        <div class="box-left">
            <img src="{{asset('dashboard/imgs/noun_Box_3093107.png')}}" alt="" />
        </div>
    </div>
    <div class="home-box pay-now2">
        <div class="box_right">
            <div class="home-num font_bold font40">{{$income}}</div>
            <div class="home-title font20">@lang('doctor.total_income')</div>
        </div>
        <div class="box-left">
            <img src="{{asset('dashboard/imgs/noun_Box_3093107.png')}}" alt="" />
        </div>
    </div>
</div>
