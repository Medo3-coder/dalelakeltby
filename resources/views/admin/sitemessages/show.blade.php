@extends('admin.layout.master')

@section('content')
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.view') . ' ' . __('admin.sitemessage') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="show form-horizontal">

                                <div class="row">
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.user_name') }}</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" value="{{ $sitemessage->name }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.country_code') }}</label>
                                            <div class="controls">
                                                <input type="text" class="form-control"
                                                    value="{{ $sitemessage->country_code }}" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.phone') }}</label>
                                            <div class="controls">
                                                <input type="text" class="form-control" value="{{ $sitemessage->phone }}"
                                                    disabled>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.text_of_message') }}</label>
                                            <div class="controls">
                                                <textarea class="form-control" cols="30" messages="10" disabled>{{ $sitemessage->message }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script>
        $('.show input').attr('disabled', true)
        $('.show textarea').attr('disabled', true)
        $('.show select').attr('disabled', true)
    </script>
@endsection
