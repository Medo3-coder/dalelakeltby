<h5 class="font_bold">{{ $data['string'] }}</h5>
<div class="text-center"><img class="img-pay" src="{{ asset('/') }}dashboard/imgs/43.png" alt=""></div>
<div class="flex-income">
    <div class="home-box pay-now3">
        <div class="box_right">
            <div class="home-num font_bold font40">{{ $data['totalCash'] }}</div>
            <div class="home-title font20">{{ __('store.The total cash') }}</div>
        </div>
        <div class="box-left">
            <img src="{{ asset('/') }}dashboard/imgs/noun_Box_3093107.png" alt="" />
        </div>
    </div>
    <div class="pay-now3 home-box-spe">
        <div class="home-box3">
            <div class="box_right">
                <div class="home-num font_bold font40">{{ $data['totalInstallment'] }}</div>
                <div class="home-title font20">{{ __('store.Total installment') }}</div>
            </div>
            <div class="box-left">
                <img src="{{ asset('/') }}dashboard/imgs/noun_Box_3093107.png" alt="" />
            </div>
        </div>
        <div class="flex-box-in-spe">
            <div class="right-b-fl">
                <div class="font_bold">{{ $data['totalInstallmentPending'] }}</div>
                <div class="font_bold">{{ __('store.stall') }}</div>
            </div>
            <div class="right-b-fl">
                <div class="font_bold">{{ $data['totalInstallmentFinished'] }}</div>
                <div class="font_bold">{{ __('store.feces') }}</div>
            </div>
        </div>
    </div>
    <div class="pay-now3 home-box-spe">
        <div class="home-box3">
            <div class="box_right">
                <div class="home-num font_bold font40">{{ $data['totalOnline'] }}</div>
                <div class="home-title font20">{{ __('store.Electronic payment total') }}</div>
            </div>
            <div class="box-left">
                <img src="{{ asset('/') }}dashboard/imgs/noun_Box_3093107.png" alt="" />
            </div>
        </div>
        <div class="flex-box-in-spe">
            <div class="right-b-fl">
                <div class="font_bold">{{ $data['totalZain'] }}</div>
                <div class="font_bold">{{ __('store.zain') }}</div>
            </div>
            <div class="right-b-fl">
                <div class="font_bold">{{ $data['totalAsia'] }}</div>
                <div class="font_bold">{{ __('store.asia') }}</div>
            </div>
            <div class="right-b-fl">
                <div class="font_bold">{{ $data['totalMaster'] }}</div>
                <div class="font_bold">{{ __('store.master') }}</div>
            </div>
            <div class="right-b-fl">
                <div class="font_bold">{{ $data['totalVisa'] }}</div>
                <div class="font_bold">{{ __('store.visa') }}</div>
            </div>
        </div>
    </div>
    <div class="home-box pay-now3">
        <div class="box_right">
            <div class="home-num font_bold font40">{{ $data['totalIncome'] }}</div>
            <div class="home-title font20">{{ __('store.Gross income') }}</div>
        </div>
        <div class="box-left">
            <img src="{{ asset('/') }}dashboard/imgs/noun_Box_3093107.png" alt="" />
        </div>
    </div>
</div>