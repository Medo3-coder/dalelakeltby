<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap.min.css.map') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/css-rtl/plugins/extensions/toastr.css') }}">

    <link rel="stylesheet" href="{{ asset('dashboard/css/jquery.fancybox.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('dashboard/css/style-dash.css') }}" />

    <link rel="stylesheet" href="{{ asset('/site') }}/flag/build/css/intlTelInput.min.css" />
    <style>
        .iti--allow-dropdown .iti__flag-container,
        .iti--separate-dial-code .iti__flag-container {
            right: 11px !important;
            width: 100px;
        }
    </style>

    @stack('css')

    <title>{{__('site.' . request()->segment(1) . '_dashboard')}}</title>
</head>

<body>
    <div class="loader">
        <img class="wow bounceIn" src="{{ asset('dashboard/imgs/Group 81396.png') }}" alt="" />
    </div>
