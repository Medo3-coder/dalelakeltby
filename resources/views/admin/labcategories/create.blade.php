@extends('admin.layout.master')
{{-- extra css files --}}
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
@endsection
{{-- extra css files --}}

@section('content')
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        @if ($parent)
                            <h4 class="card-title">{{ __('admin.add') . ' ' . __('admin.sub_category') . ' ' . __('admin.from') }} ( {{$parent->name}} ) </h4>
                        @else
                            <h4 class="card-title">{{ __('admin.add') . ' ' . __('admin.labcategory') }}</h4>
                        @endif
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.labcategories.store', request()->parent_id) }}"
                                class="store form-horizontal" novalidate>
                                @csrf
                                <input type="hidden" name="parent_id" value="{{ request()->parent_id }}">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">

                                            <div class="row">



                                                @foreach (languages() as $lang)
                                                    <div class="col-md-6 col-12">
                                                        <div class="form-group">
                                                            <label
                                                                for="first-name-column">{{ __('site.name_' . $lang) }}</label>
                                                            <div class="controls">
                                                                <input type="text" name="name[{{ $lang }}]"
                                                                    class="form-control"
                                                                    placeholder="{{ __('site.write') . __('site.name_' . $lang) }}"
                                                                    required
                                                                    data-validation-required-message="{{ __('admin.this_field_is_required') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach


                                                @if (!$parent))
                                                    <div class="col-md-6 col-6">
                                                        <div class="form-group">
                                                            <label
                                                                for="first-name-column">{{ __('admin.has_targeted_bodies') }}</label>
                                                            <div class="controls">
                                                                <select name="has_targeted_body"
                                                                    class="select2 form-control" required
                                                                    data-validation-required-message="{{ __('admin.this_field_is_required') }}">

                                                                    <option value="1">
                                                                        {{ __('admin.yes') }}</option>

                                                                    <option value="0">
                                                                        {{ __('admin.no') }}</option>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>


                                            <div class="col-12 d-flex justify-content-center mt-3">
                                                <button type="submit"
                                                    class="btn btn-primary mr-1 mb-1 submit_button">{{ __('admin.add') }}</button>
                                                <a href="{{ url()->previous() }}" type="reset"
                                                    class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
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
    <script src="{{ asset('admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/forms/validation/form-validation.js') }}"></script>
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>

    {{-- show selected image script --}}
    @include('admin.shared.addImage')
    {{-- show selected image script --}}

    {{-- submit add form script --}}
    @include('admin.shared.submitAddForm')
    {{-- submit add form script --}}
@endsection
