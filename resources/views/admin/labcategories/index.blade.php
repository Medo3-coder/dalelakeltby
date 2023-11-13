@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('admin/index_page.css') }}">
@endsection

@section('content')
    <x-admin.table datefilter="true" order="true" extrabuttons="true"
        addbutton="{{ isset(request()->parent_id) ? route('admin.labcategories.create', request()->parent_id) : false }}"
        {{--  deletebutton="{{ route('admin.labcategories.deleteAll') }}"   --}} :searchArray="[
            'name' => [
                'input_type' => 'text',
                'input_name' => __('admin.name'),
            ],
        ]">

        <x-slot name="extrabuttonsdiv">
            @if (isset($parent))
                <h4 class="card-title mb-1 mt-1">{{ __('admin.sub_categories') . ' ' . __('admin.of') }} (
                    {{ $parent->name }} ) </h4>
            @endif
        </x-slot>

        <x-slot name="tableContent">
            <div class="table_content_append">
                {{-- table content will appends here  --}}
            </div>
        </x-slot>
    </x-admin.table>
@endsection

@section('js')
    <script src="{{ asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js') }}"></script>
    @include('admin.shared.deleteAll')
    @include('admin.shared.deleteOne')
    @include('admin.shared.filter_js', [
        'index_route' => url('admin/labcategories/all/' . request()->parent_id),
    ])
@endsection
