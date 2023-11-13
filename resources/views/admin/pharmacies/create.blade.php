@extends('admin.layout.master')
{{-- extra css files --}}
@section('css')
    <link rel="stylesheet" type="text/css"
        href="{{ asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/lab.css') }}">
    @livewireStyles
    <style>
        .branch_images_image {
            position: relative;
            cursor: pointer;
        }

        .branch_images_image i {
            color: #1d1a1a;
            font-size: 30px;
            position: absolute;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%)
        }

        .branch_images_image:hover:hover i {
            color: #f00
        }
    </style>
@endsection

{{-- extra css files --}}

@section('content')
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header ">
                        <h4 class="card-title mb-2">{{ __('admin.add') . ' ' . __('admin.pharmacy') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form method="POST" enctype="multipart/form-data" class="store form-horizontal" novalidate>
                                @csrf

                                <livewire:admin.pharmacy.create-pharmacy />

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

    @livewireScripts

    {{-- show selected image script --}}
    @include('admin.shared.addImage')
    {{-- show selected image script --}}

    {{-- submit add form script --}}
    @include('admin.shared.submitAddForm')
    {{-- submit add form script --}}

    @include('admin.partials.map', ['draggable' => true])
@endsection
