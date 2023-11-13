<li class="spe-col-act">
    <a class="collapse-co spe-link-spe">
        <span class="icon-co">
            <img src="{{ asset('dashboard/imgs/Path 48146.png') }}" alt="" />
        </span>
        @lang('site.reservations')
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>

    <ul class="collapse-me">
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
            <a href="{{ url('lab/new-reservations') }}">
                @lang('site.new_reservations')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/Page-1dd.png') }}" alt="" />
            <a href="{{ url('lab/accepted-reservations') }}">
                @lang('site.accepted_reservations')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
    </ul>
</li>

<li class="spe-col-act">
    <a class="collapse-co spe-link-spe">
        <span class="icon-co">
            <img src="{{ asset('dashboard/imgs/Group 83199.png') }}" alt="" />
        </span>
        @lang('site.mostzmay')
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
    <ul class="collapse-me">
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
            <a href="{{ route('lab.medicalDevices.offers') }}">
                @lang('site.offers')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/Page-1dd.png') }}" alt="" />
            <a href="{{ route('lab.medicalDevices.myOrders') }}">
                @lang('site.orders')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
    </ul>
</li>

<li class="spe-col-act">
    <a href="{{ route('lab.medicalTests.index') }}" class="spe-link-spe">
        <span class="icon-co">
            <img src="{{ asset('dashboard/imgs/Group 83199.png') }}" alt="" />
        </span>
        @lang('site.add_medical_analyzes')
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
</li>

<li class="spe-col-act">
    <a class="collapse-co spe-link-spe">
        <span class="icon-co">
            <img src="{{ asset('dashboard/imgs/Path 48154.png') }}" alt="" />
        </span>
        @lang('site.add_roles')
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
    <ul class="collapse-me">
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
            <a href="{{ route('lab.rules.add') }}">
                @lang('site.add_roles')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/Group 81387.png') }}" alt="" />
            <a href="{{ route('lab.rules.index') }}">
                @lang('site.added_acounts')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
    </ul>
</li>

<li class="spe-col-act">
    <a class="collapse-co spe-link-spe">
        <span class="icon-co">
            <img src="{{ asset('dashboard/imgs/Group 81356.png') }}" alt="" />
        </span>
        @lang('localize.reports')
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
    <ul class="collapse-me">
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/Group 8333dddfffffffff3.png') }}" alt="" />
            <a href="{{ route('lab.reports.finished') }}">@lang('localize.full_checks')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/Group 82936.png') }}" alt="" />
            <a href="{{ route('lab.reports.income') }}">
                @lang('localize.income')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
            <a href="{{ route('lab.reports.orders.pendingPayment') }}">
                @lang('localize.order_pending_payments')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/Page-1dd.png') }}" alt="" />
            <a href="{{route('lab.reports.orders.paid')}}">
                @lang('localize.paid_payments')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
    </ul>
</li>

<li class="spe-col-act">
    <a href="{{ route('lab.suggestions.index') }}" class="spe-link-spe">
        <span class="icon-co">
            <img src="{{ asset('dashboard/imgs/Group 81371.png') }}" alt="" />
        </span>
        @lang('localize.suggestions')
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
</li>
