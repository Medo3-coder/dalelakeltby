@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <style>
        .delete-in-edit-parent {
            opacity: .5;
        }
    </style>
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="table-top-book">
                <div class="side-heading">

                    <h6>@lang('site.control_panel')</h6>
                    <div class="links-top-to">
                        <a>@lang('site.reservations')</a> /
                        <a href="{{ route('lab.reports.finished') }}">@lang('localize.full_checks')</a> /
                        <span class="color-main">@lang('site.reservation_details')</span>
                    </div>
                </div>


            </div>
            <div class="card-white righ-left-p-0">
                <h6 class="row-tab-m">@lang('site.reservation_details')</h6>
                <div class="card-white-button">
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('site.name')</div>
                            <div class="name-card">{{ $reservation->name }}</div>
                        </div>
                        <div class="row-left">
                            <div class="name-card color-gray">@lang('site.reservation_time')</div>
                            <div class="name-card">{{ $reservation->date->format('H:i A') }}</div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('site.age')</div>
                            <div class="name-card">
                                {{ $reservation->reservation_for == 'family' ? $reservation->age : $reservation->user->age }}
                            </div>
                        </div>
                        <div class="row-left">
                            <div class="name-card color-gray">@lang('site.reservation_date')</div>
                            <div class="name-card">{{ $reservation->date->format('d-m-Y') }}</div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('site.blood_type')</div>
                            <div class="name-card">
                                {{ $reservation->reservation_for == 'family' ? $reservation->patientBloodType->name : $reservation->user->bloodType->name }}
                            </div>
                        </div>
                        <div class="row-left">
                            <div class="name-card color-gray">@lang('site.transfer_from_doctor')</div>
                            <div class="name-card">{{ $reservation->doctor_id != null ? __('site.yes') : __('site.no') }}
                            </div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('localize.weight')</div>
                            <div class="name-card">{{ $reservation->weight }}</div>
                        </div>
                        @if ($reservation->doctor)
                            <div class="row-left">
                                <div class="name-card color-gray">@lang('localize.doctor_name')</div>
                                <div class="name-card">{{ $reservation->doctor->name }}</div>
                            </div>
                        @endif
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('localize.length')</div>
                            <div class="name-card">{{ $reservation->length }}</div>
                        </div>
                        <div class="row-left">
                            <div class="name-card color-gray">@lang('localize.notes')</div>
                            <div class="name-card">{{ $reservation->details ?? __('localize.not_found') }}</div>
                        </div>
                    </div>
                    <div class="row1">
                        <div class="row-right">
                            <div class="name-card color-gray">@lang('localize.gender')</div>
                            <div class="name-card">{{ __('doctor.' . $reservation->gender) }}</div>
                        </div>
                        <div class="row-left">
                            <div class="name-card color-gray">@lang('localize.app_commition')</div>
                            <div class="name-card">{{ $reservation->admin_commission_amount . ' ' . __('site.currency') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-white">
                <h5>@lang('localize.required_tests')</h5>
                @foreach ($reservation->labSubCategories as $test)
                    <p>{{ $test->labSubCategory->name }}</p>
                @endforeach
                <h5 class="mt-3">@lang('localize.test_details')</h5>
                <p>{{ $reservation->details }}</p>
            </div>

            @if ($reservation->labSubcategoryReservationHasMany->where('result', '!=', null)->count() > 0)
                <div class="card-white text-center">
                    <div class="top-buttom">
                        <h5>@lang('localize.result_of_the_test')</h5>
                    </div>
                    <a href="#" class="test-result-big up" data-toggle="modal" data-target="#viewResultModal">
                        <i class="fa-solid fa-book-open"></i>
                        @lang('localize.show__test_result')
                    </a>
                </div>
            @endif
        </div>
    </main>


    @include('providers_dashboards.lab.reports.reservations.details._view_result_model')
@endsection
