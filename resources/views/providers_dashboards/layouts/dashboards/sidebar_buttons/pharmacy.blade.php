<li class="spe-col-act">
    <a href="{{ route('pharmacy.stores.index') }}" class="spe-link-spe">
        <span class="icon-co">
            <img src="{{ asset('dashboard/imgs/Group 83199.png') }}" alt="" />
        </span>
        @lang('localize.stores')
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
</li>
<li class="spe-col-act">
    <a class="collapse-co spe-link-spe">
        <span class="icon-co">
            <img src="{{ asset('dashboard/imgs/Group 81356.png') }}" alt="" />
        </span>
        @lang('localize.trace_my_orders')
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
    <ul class="collapse-me">
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/Group 8333dddfffffffff3.png') }}" alt="" />
            <a href="{{ route('pharmacy.myOrders.pending') }}"> @lang('localize.pending_orders')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/Group 82936.png') }}" alt="" />
            <a href="{{ route('pharmacy.myOrders.accepted') }}">
                @lang('localize.accepted_orders')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
            <a href="{{ route('pharmacy.myOrders.prepared') }}">
                @lang('localize.prepared_orders')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/Page-1dd.png') }}" alt="" />
            <a href="{{ route('pharmacy.myOrders.rejected') }}">
                @lang('localize.canceled_orders')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
    </ul>
</li>

<li class="spe-col-act">
    <a class="collapse-co spe-link-spe">
        <span class="icon-co">
            <img src="{{ asset('dashboard/imgs/Path 48154.png') }}" alt="" />
        </span>
        {{ __('doctor.add_permission') }}
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
    <ul class="collapse-me">
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
            <a href="{{ route('pharmacy.rules.add') }}">
                {{ __('doctor.add_permissions') }}
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/Group 81387.png') }}" alt="" />
            <a href="{{ route('pharmacy.rules.index') }}">
                {{ __('doctor.added_accounts') }}
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
            <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
            <a href="{{ route('pharmacy.reports.orders.pendingPayment') }}">
                @lang('localize.orders_pending_payment')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/Page-1dd.png') }}" alt="" />
            <a href="{{ route('pharmacy.reports.orders.paid') }}">
                @lang('localize.paid_orders')
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
    </ul>
</li>
<li class="spe-col-act">
    <a href="{{ route('pharmacy.suggestions.index') }}" class="spe-link-spe">
        <span class="icon-co">
            <img src="{{ asset('dashboard/imgs/Group 81371.png') }}" alt="" />
        </span>
        {{ __('doctor.suggestions') }}
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
</li>
