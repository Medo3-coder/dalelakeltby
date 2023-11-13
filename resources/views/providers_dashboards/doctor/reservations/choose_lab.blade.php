@extends('providers_dashboards.layouts.dashboards.master')

@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading">
                <h6>@lang('doctor.dashboard')</h6>
                <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('doctor')->user()->name])</p>
            </div>
            <div class="devices-boxs card-white spe-pad">
                <div class="row">
                    @foreach ($categoriesLabs as $categoriesLab)
                        <div class="col-lg-4 col-md-6 col-12">
                            <div class="device-box">
                                <img src="{{ $categoriesLab->lab->image }}" alt="">
                                <div class="card_foot card-f-spe">
                                    <div class="flex-device mt-0">
                                        <h6 class="text-center font_bold no-border-bottom">{{ $categoriesLab->lab->name }}
                                        </h6>
                                        <div class="left-device white-fire">{{ $categoriesLab->labCategory->name }}</div>
                                    </div>
                                    <div class="white-fire">
                                        <div class="right-device mb-1">{{ __('admin.address') }} /
                                            {{ $categoriesLab->lab->address }}</div>
                                        <div class="right-device mb-1">{{ __('admin.email') }} /
                                            {{ $categoriesLab->lab->email }}</div>
                                        <div class="right-device mb-1">{{ __('admin.phone') }} /
                                            {{ $categoriesLab->lab->phone }}</div>
                                    </div>
                                    <div class="flex-device justify-content-center mt-3">
                                        <a href="{{ route('doctor.reservations.labReservation', [
                                            'reservation_id' => $reservation->id,
                                            'lab' => $categoriesLab->lab_id,
                                            'lab_category' => $categoriesLab->labCategory->id,
                                        ]) }}"
                                            class="link-device up">{{ __('site.more') }}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="pag-all d-flex align-items-center justify-content-between">
                    <div class="pag-right">@lang('site.show_results_from')
                        {{ $categoriesLabs->firstItem() }}-{{ $categoriesLabs->total() }}</div>
                    <div class="pag-left">{{ $categoriesLabs->links() }}</div>
                </div>
            </div>
    </main>
@endsection
