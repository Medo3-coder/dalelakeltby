<li class="spe-col-act">
    <a href="#" class="collapse-co spe-link-spe">
        <span class="icon-co">
            <img src="{{ asset('dashboard/imgs/Path 48146.png') }}" alt="" />
        </span>
        {{ __('doctor.reservations') }}
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
    <ul class="collapse-me">
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
            <a href="{{ route('doctor.reservations.new') }}">
                {{ __('doctor.incomming_orders') }}
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('dashboard/imgs/Page-1dd.png') }}" alt="" />
            <a href="{{ route('doctor.reservations.accepted') }}">
                {{ __('doctor.accepted_orders') }}
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
    </ul>
</li>

{{-- @provider --}}
    <li class="spe-col-act">
        <a href="#" class="collapse-co spe-link-spe">
            <span class="icon-co">
                <img src="{{ asset('dashboard/imgs/Group 81356.png') }}" alt="" />
            </span>
            {{ __('doctor.reports') }}
            <i class="fa-solid fa-angle-left icon-right"></i>
        </a>
        <ul class="collapse-me">
            <li class="coll col-spe">
                <img src="{{ asset('dashboard/imgs/Group 8333dddfffffffff3.png') }}" alt="" />
                <a href="{{ route('doctor.reports.finished') }}">{{ __('doctor.finished_orders') }}
                    <i class="fa-solid fa-angle-left icon-right"></i>
                </a>
            </li>
            <li class="coll col-spe">
                <img src="{{ asset('dashboard/imgs/Group 82936.png') }}" alt="" />
                <a href="{{ route('doctor.reports.canceled') }}">
                    {{ __('doctor.canceld_orders') }}
                    <i class="fa-solid fa-angle-left icon-right"></i>
                </a>
            </li>
            <li class="coll col-spe">
                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                <a href="{{ route('doctor.reports.income') }}">
                    {{ __('doctor.income') }}
                    <i class="fa-solid fa-angle-left icon-right"></i>
                </a>
            </li>
        </ul>
    </li>
{{-- @endprovider --}}

<li class="spe-col-act">
    <a href="{{ route('doctor.medicine.index') }}" class="spe-link-spe">
        <span class="icon-co">
            <img src="{{ asset('dashboard/imgs/Group 81371.png') }}" alt="" />
        </span>
        {{ __('doctor.my_medicines') }}
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
</li>
{{-- @provider --}}
    <li class="spe-col-act">
        <a href="#" class="collapse-co spe-link-spe">
            <span class="icon-co">
                <img src="{{ asset('dashboard/imgs/Path 48154.png') }}" alt="" />
            </span>
            {{ __('doctor.add_permission') }}
            <i class="fa-solid fa-angle-left icon-right"></i>
        </a>
        <ul class="collapse-me">
            <li class="coll col-spe">
                <img src="{{ asset('dashboard/imgs/noun_Box_3093107.png') }}" alt="" />
                <a href="{{ route('doctor.rules.add') }}">
                    {{ __('doctor.add_permissions') }}
                    <i class="fa-solid fa-angle-left icon-right"></i>
                </a>
            </li>
            <li class="coll col-spe">
                <img src="{{ asset('dashboard/imgs/Group 81387.png') }}" alt="" />
                <a href="{{ route('doctor.rules.index') }}">
                    {{ __('doctor.added_accounts') }}
                    <i class="fa-solid fa-angle-left icon-right"></i>
                </a>
            </li>
        </ul>
    </li>

    <li class="spe-col-act">
        <a href="{{ route('doctor.opinions.index') }}" class="spe-link-spe">
            <span class="icon-co">
                <img src="{{ asset('dashboard/imgs/Group 81371.png') }}" alt="" />
            </span>
            {{ __('doctor.rates') }}
            <i class="fa-solid fa-angle-left icon-right"></i>
        </a>
    </li>

    <li class="spe-col-act">
        <a href="{{route('doctor.suggestions.index')}}" class="spe-link-spe">
            <span class="icon-co">
                <img src="{{ asset('dashboard/imgs/Group 81371.png') }}" alt="" />
            </span>
            {{ __('doctor.suggestions') }}
            <i class="fa-solid fa-angle-left icon-right"></i>
        </a>
    </li>
{{-- @endprovider --}}
