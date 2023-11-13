<div class="sidebar" id="sidebar">
    <div class="close" id="closeSidebar">
        <i class="fa-solid fa-xmark"></i>
    </div>
    <div class="content">
        <div class="logo">
            <div class="flex-logo">
                <img src="{{ asset('dashboard/imgs/Medical guide 2.png') }}" alt="" />
                <div class="logo-left">
                    <h6>@lang('site.site_name')</h6>
                    <p>@lang('site.dashboard') @lang('site.' . request()->segment(1))</p>
                </div>
            </div>
        </div>
        <ul class="links">
            @if (auth(request()->segment(1))->check())
                <li class="spe-col-act">
                    <a href="{{ route(request()->segment(1) . '.home') }}"
                        class="{{ request()->is('la') ? 'active' : '' }}">
                        <span class="icon-co">
                            <img src="{{ asset('dashboard/imgs/noun_dashboard_3595546.png') }}" alt="" />
                        </span>
                        @lang('site.home') <i class="fa-solid fa-angle-left icon-right"></i>
                    </a>
                </li>

                @include('providers_dashboards.layouts.dashboards.sidebar_buttons.' . request()->segment(1))

                <li class="spe-col-act">
                    <a href="{{ url(request()->segment(1) . '/logout?device_id=11111111') }}" class="spe-link-spe">
                        <span class="icon-co">
                            <img src="{{ asset('dashboard/imgs/noun_logout.png') }}" alt="" />
                        </span>
                        @lang('site.logout')
                        <i class="fa-solid fa-angle-left icon-right"></i>
                    </a>
                </li>
            @endif
        </ul>

        <div class="lines-side container mt-5">
            <div class="lines-side1">@lang('site.all_rights')@2022</div>
            <div class="lines-side1">@lang('site.design_by')<a target="_blank" href="https://aait.sa/">@lang('site.awamer')</a></div>
        </div>
    </div>
</div>
