@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="table-top-book">
                <div class="side-heading">
                    <h6>@lang('doctor.dashboard')</h6>
                    <div class="links-top-to">
                        <a>@lang('doctor.reservations')</a> /
                        @foreach ($breadCrambRouts as $routeName => $routeTitle)
                            <a href="{{ route($routeName) }}">{{ $routeTitle }}</a> /
                        @endforeach
                        <span class="color-main">@lang('doctor.reservation_details')</span>
                    </div>
                </div>
                <div class="mb-2 nice-flex">
                    @if ($reservation->status == 'transfer_to_lab')
                        <a class="test-result  accept-patient follow followed followed2 no-hover">
                            <img src="{{ asset('dashboard/imgs/Group 83289.png') }}" alt="" />
                            @lang('doctor.patient_sent_to_lab')
                        </a>
                    @elseif ($reservation->status !== 'finished')
                        <a href="{{ route('doctor.reservations.chooseLab', $reservation->id) }}"
                            class="test-result sentToLab no-hover">
                            <img src="{{ asset('dashboard/imgs/Group 83289.png') }}" alt="" />
                            @lang('doctor.tranfere_to_lab')
                        </a>

                        <a href="#" class="test-result no-hover" data-toggle="modal" data-target="#exampleModal">
                            <img src="{{ asset('dashboard/imgs/Group 82986.png') }}" alt="" />
                            @lang('doctor.write_receipt')
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-white righ-left-p-0">
                <h6 class="row-tab-m">@lang('doctor.reservation_info')</h6>
                <div class="card-white-button font-700">
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('site.name')</div>
                            <div class="name-card">
                                {{ $reservation->name }}
                            </div>
                        </div>
                        @if ($reservation->reservation_for == 'same_person')
                            <div class="row-left">
                                <div class="name-card color-gray">@lang('doctor.gender')</div>
                                <div class="name-card">@lang('doctor.' . $reservation->user->gender)</div>
                            </div>
                        @endif
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.age')</div>
                            <div class="name-card">
                                {{ $reservation->age }}
                            </div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.bloodType')</div>
                            <div class="name-card">
                                {{ $reservation->reservation_for == 'same_person' ? $reservation->user->bloodType->name : $reservation->patientBloodType->name }}
                            </div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.weight')</div>
                            <div class="name-card">
                                {{ $reservation->weight }}
                            </div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.length')</div>
                            <div class="name-card">
                                {{ $reservation->height }}
                            </div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.reservation_time')</div>
                            <div class="name-card">
                                {{ $reservation->reservation_time }}
                            </div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.reservation_date')</div>
                            <div class="name-card">
                                {{ $reservation->reservation_date }}
                            </div>
                        </div>
                    </div>
                    @if ($reservation->clinic)
                        <div class="row1">
                            <div class="row-right">
                                <div class="name-card color-gray">@lang('doctor.clinic')</div>
                                <div class="name-card color-main">
                                    <i class="fa-solid fa-paper-plane"></i>
                                    {{ $reservation->clinic->name }}
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.notes')</div>
                            <div class="name-card">
                                {{ $reservation->notes ?? __('doctor.not_found') }}
                            </div>
                        </div>
                    </div>

                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('doctor.app_commission')</div>
                            <div class="name-card">
                                {{ $reservation->admin_commission_amount . ' ' . __('site.currency') }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>


        </div>
    </main>
@endsection
