@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
    <link rel="stylesheet" href="{{ asset('/') }}dashboard/css/month.css">
@endpush
@section('content')

    <main class="main-sec" id="main">
        <div class="container">
            <div class="table-top-book">
                <div class="side-heading">
                    <h6>{{ __('store.your personal income') }}</h6>
                    <p>@lang('site.control_panel_welcom_message', ['user_name' => auth('store')->user()->name])</p>
                </div>
                <div class="waiting">
                    <div class="select-spe">
                        <div class="select-spe-text">{{ __('store.filter per day') }}</div>
                        <div class="inp-date-con">
                            <input
                                    type="date"
                                    id="myDate"
                                    placeholder="{{ __('store.Choose today') }}"
                                    class="default-date-inp"
                                    value="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"
                            />
                            <i class="fa-regular fa-calendar"></i>
                        </div>
                    </div>
                    <div class="select-spe ">
                        <div class="select-spe-text">{{ __('store.Date filter') }}</div>
                        <div class="inp-date-con">
                        <input
                                type="text"
                                id="myMonth"
                                placeholder="{{ __('store.Choose the date') }}"
                                class="default-date-inp"
                                value="{{ \Carbon\Carbon::now()->translatedFormat('j F Y') }}"
                        />
                        <i class="fa-regular fa-calendar"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-white result-filter">

            </div>
        </div>


    </main>


@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/{{ app()->getLocale() }}.js"></script>
    <script src="{{ asset('/') }}dashboard/js/month.js"></script>

    <script>

        $(document).ready(function (){
            flatpickr("#myDate", {
                disableMobile: "true",
                locale: "{{ app()->getLocale() }}",
                onChange : function (selectedDates){
                    $('#myMonth').val('');
                    var date =  new Date(selectedDates);
                    var day =  date.toLocaleDateString('en-US', { day: 'numeric',month: '2-digit', year: 'numeric' });
                    var type = 'day';

                    filterAjax(type, day, $('#myDate'))
                }
            });

            flatpickr("#myMonth", {
                locale: "{{ app()->getLocale() }}",
                disableMobile: "true",
                enableTime: true,
                dateFormat: "Y-m",
                altFormat: "F-Y",
                plugins: [new monthSelectPlugin({})],
                onReady : function (selectedDates){
                    $('#myDate').val('')
                    var date =  new Date(selectedDates);
                    var month =  date.toLocaleDateString('en-US', { year: 'numeric', month: '2-digit'});
                    var type = 'month';
                    filterAjax(type, month, $('#myMonth'))
                },
                onChange : function (selectedDates){
                    $('#myDate').val('')
                    var date =  new Date(selectedDates);
                    var month =  date.toLocaleDateString('en-US', { year: 'numeric', month: '2-digit'});
                    var type = 'month';
                    filterAjax(type, month, $('#myMonth'))
                }

            });

            function filterAjax(type,value, el){
                $(el).ajaxSubmit({
                    url: '{{ route('store.reports.income') }}',
                    method:"GET",
                    data:{
                        _token:'{{ csrf_token() }}',
                        type:type,
                        value:value
                    },
                    success: (response) => {
                        if(response.status == 'success'){
                            $('.result-filter').html(response.html)
                        }else {
                            Swal.fire({
                                icon: 'error',
                                iconColor: '#ff0000',
                                title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, something went wrong!') }}' +'</h5>',
                                showConfirmButton: true,
                                confirmButtonText: '{{ __('store.ok') }}',

                            })
                        }

                    },
                    error: function (xhr) {
                        Swal.fire({
                            icon: 'error',
                            iconColor: '#ff0000',
                            title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, something went wrong!') }}' +'</h5>',
                            showConfirmButton: true,
                            confirmButtonText: '{{ __('store.ok') }}',

                        })
                    },
                });


            }
        })

    </script>
@endpush
