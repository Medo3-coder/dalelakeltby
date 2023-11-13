@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="table-top-book">
                <div class="side-heading">
                    <h6>@lang('doctor.medicines')</h6>
                    <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('doctor')->user()->name])</p>
                </div>
                <a href="{{ route('doctor.medicine.create') }}"
                    class="test-result up add-medicine">{{ __('doctor.add_medicine') }}</a>
            </div>

            <div class="overflowx_auto mb-3">
                <table class="table text-center" style="width: 100%">
                    <thead class="table-head">
                        <tr>
                            <th class="font10">@lang('site.serial_number')</th>
                            <th class="font10">@lang('admin.image')</th>
                            <th class="font10">@lang('site.name')</th>
                            <th class="font10">@lang('doctor.type')</th>
                            <th class="font10"></th>
                            <th class="font10"></th>
                        </tr>
                    </thead>
                    <tbody data-class-name="table-body">
                        @foreach ($medicines as $key => $medicine)
                            <tr>
                                <td class="font12">#{{ ++$key }}</td>

                                <td class="font12"><img src="{{ $medicine->image }}" style="width:100px" alt=""></td>
                                <td class="font12">{{ $medicine->name }}</td>
                                <td class="font12">{{ $medicine->type }}</td>


                                <td class="font12">
                                    <a href="{{route('doctor.medicine.edit' ,$medicine->id)}}">
                                        <button type="button" class="accept_order table-btn-spe main-bg up">
                                            @lang('doctor.edit')
                                        </button>
                                    </a>
                                </td>

                                <td class="font12">
                                    <button type="button" data-url="{{ route('doctor.medicine.delete', $medicine->id) }}"
                                        class=" delete-row refuse_order table-btn-spe danger-bg up danger-h"
                                        data-toggle="modal" data-target="#staticBackdrop"
                                        data-reservation_id="{{ $medicine->id }}">
                                        @lang('doctor.delete')
                                    </button>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @if (count($medicines) == 0)
                    <div class="no-data d-flex justify-content-center">
                        <img src="{{ asset('/') }}dashboard/imgs/empty.png" alt="">
                    </div>
                @endif
            </div>
        </div>
    </main>
@endsection
@push('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js')}}"></script>
    @include('shared.deleteOne')
@endpush
