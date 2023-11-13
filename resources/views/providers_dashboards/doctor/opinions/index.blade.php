@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">
@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="card-white">
                <div class="opinion-top">
                    <h5 class="font_bold mb-4">@lang('localize.patient_opinions')</h5>
                </div>
                <div class="opinion-grid">
                    <div class="rright-grid rright-grid1">
                        @foreach ($reservations as $index => $reservation)
                            @if ($index % 2 == 0)
                                <div class="opinion-flex">
                                    <div class="left-flex no-border-bottom p-0">
                                        <img src="{{ $reservation->user->image }}" alt="" />
                                        <div class="inner-left">
                                            <h6 class="no-border-bottom pb-0">{{ $reservation->user->name }}</h6>
                                            <div class="inner-flex">
                                                <i class="fa-regular fa-clock gray-col"></i>
                                                <div class="time-left gray-col">
                                                    {{ $reservation->updated_at->diffForHumans() }}
                                                </div>
                                                <div class="stars-container-spe">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        @if ($i <= $reservation->rate)
                                                            <i class="fa-solid fa-star star-yel"></i>
                                                        @else
                                                            <i class="fa-solid fa-star star-gray"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="gray-col max-85">
                                                {{ $reservation->comment }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class=" right-op make_report" data-id="{{ $reservation->id }}">
                                        <img src="{{ asset('dashboard/imgs/Component 50 – 1.png') }}" alt="">
                                        <div class="flag-titlespe">@lang('localize.make_report')</div>
                                    </div>
                                </div>
                                <hr>
                            @endif
                        @endforeach

                    </div>
                    <div class="rright-grid">

                        @foreach ($reservations as $index => $reservation)
                            @if ($index % 2 == 1)
                                <div class="opinion-flex">
                                    <div class="left-flex no-border-bottom p-0">
                                        <img src="{{ $reservation->user->image }}" alt="" />
                                        <div class="inner-left">
                                            <h6 class="no-border-bottom pb-0">{{ $reservation->user->name }}</h6>
                                            <div class="inner-flex">
                                                <i class="fa-regular fa-clock gray-col"></i>
                                                <div class="time-left gray-col">
                                                    {{ $reservation->updated_at->diffForHumans() }}
                                                </div>
                                                <div class="stars-container-spe">
                                                    @for ($i = 0; $i < 5; $i++)
                                                        @if ($i <= $reservation->rate)
                                                            <i class="fa-solid fa-star star-yel"></i>
                                                        @else
                                                            <i class="fa-solid fa-star star-gray"></i>
                                                        @endif
                                                    @endfor
                                                </div>
                                            </div>
                                            <p class="gray-col max-85">
                                                {{ $reservation->comment }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class=" right-op make_report" data-id="{{ $reservation->id }}">
                                        <img src="{{ asset('dashboard/imgs/Component 50 – 1.png') }}" alt="">
                                        <div class="flag-titlespe">@lang('localize.make_report')</div>
                                    </div>
                                </div>
                                <hr>
                            @endif
                        @endforeach
                    </div>

                </div>
                @if (count($reservations) == 0)
                    <div class="text-center">
                        <h3 class="m-5">@lang('localize.not_found')</h3>
                        <img src="{{ asset('/') }}dashboard/imgs/empty.png" alt="">
                    </div>
                @endif

                {{ $reservations->links() }}
            </div>


    </main>

    <!-- Modal 1 -->
    <div class="modal fade" id="searchMODEL3" tabindex="-1" aria-labelledby="searchMODEL3Label" aria-hidden="true">
        <div class="modal-dialog modal-dialog-spe2 modal-dialog-spe4">
            <div class="modal-content">
                <div class="modal-body no-border-bottom modal2-spe">
                    <h5 class="font_bold mb-3">@lang('admin.add_reportrate')</h5>
                    <form action="{{ route('doctor.opinions.report') }}" method="POST"
                        data-success="$('#searchMODEL3').modal('hide');" class="form">
                        @csrf
                        <input type="hidden" name="reservation_id" id="id">

                        <div class="mb-3 main-inp-cont col-12">
                            <h6 class="fontBold mainColor font14">@lang('admin.reportrate')</h6>
                            <div class="form__label">
                                <textarea placeholder="@lang('admin.please_enter') @lang('admin.reportrate')" name="report" class="default_input" id=""
                                    cols="30" rows="10"></textarea>
                                <label class="float__label" for="">@lang('admin.please_enter')
                                    @lang('admin.reportrate')</label>

                            </div>
                            <div class="error_show error_report"><span class="mt-5 text-danger"></span></div>

                        </div>

                        <button class="submit submit-button wid-70 up mt-5">@lang('admin.send')</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/toastr.min.js') }}"></script>

    @include('shared.formAjax')

    <script>
        $(document).on('click', '.make_report', function() {
            $('#id').val($(this).data('id'));
            $('#searchMODEL3').modal('show');
        });
    </script>
@endpush
