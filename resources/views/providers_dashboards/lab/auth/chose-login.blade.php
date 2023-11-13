@extends('providers_dashboards.layouts.site.dashboard-auth')

@section('content')
    <section class="content">
        <section class="start">
            <div class="right-sec sec">
                <div class="content1">
                    <div class="reg-links">
                        <a href="{{route(request()->segment(1) . '.showLogin')}}" class="first-reg up">{{ __('site.login') }}
                            {{ __('site.' . request()->segment(1)) }}</a>
                        <a href="{{route(request()->segment(1) . '.showLogin' ,['type' => 'employee'])}}" class="second-reg up">{{__('site.login_employee')}}</a>
                    </div>
                </div>
            </div>
            <div class="left-sec sec">
                <div class="content2">
                    <h2 class="head">{{__('site.welcome_back_to_app')}}</h2>
                    <p class="text">
                        {{__('site.platform_login_description')}}
                    </p>
                </div>
            </div>
        </section>
    </section>
@endsection
