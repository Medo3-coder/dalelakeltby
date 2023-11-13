@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading mb-4">
                <div class="side-heading mt-4">
                    <h6>@lang('localize.notifications')</h6>
                    <p>@lang('localize.youe_show_your_notifications_her')</p>
                </div>
            </div>
            @forelse ($notifications as $notification)
                <a @if ($notification->data['url']) href="{{ $notification->data['url'] }}" @endif
                    class="noti-box mb-3 notification {{ in_array($notification->id, $unreadNotifications) ? 'active' : '' }} ">
                    <div class="noti-box-right"><i class="fa-solid fa-bell"></i></div>
                    <div class="noti-box-left">
                        <div class="noti-text font_bold mb-2">{{ $notification->title }}</div>
                        <div class="flex-noti gray-col"><i
                                class="fa-regular fa-clock"></i><span>{{ $notification->created_at->diffForHumans() }}</span>
                        </div>

                    </div>
                </a>
            @empty
                <h3 class="m-5">@lang('localize.not_found')</h3>
            @endforelse


        </div>
    </main>
@endsection
