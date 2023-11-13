@extends('admin.layout.master')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/css-rtl/plugins/forms/validation/form-validation.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/app-assets/vendors/css/extensions/sweetalert2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('admin/index_page.css')}}">
@endsection

@section('content')

<x-admin.table 
    datefilter="true" 
    order="true" 
    extrabuttons="true"
    addbutton="{{ route('admin.clients.create') }}" 
    deletebutton="{{ route('admin.clients.deleteAll') }}" 
    :searchArray="[
        'name' => [
            'input_type' => 'text' , 
            'input_name' => __('admin.name') , 
        ],
        'phone' => [
            'input_type' => 'text' , 
            'input_name' => __('admin.phone') , 
        ] ,
        'email' => [
            'input_type' => 'text' , 
            'input_name' => __('admin.email') , 
        ] ,
        'is_blocked' => [
            'input_type' => 'select' , 
            'rows'       => [
              '1' => [
                'name' => 'محظور' , 
                'id' => 1 , 
              ],
              '2' => [
                'name' => 'غير محظور' , 
                'id' => 0 , 
              ],
            ] , 
            'input_name' => __('admin.ban_status') , 
        ] ,
        'active' => [
            'input_type' => 'select' , 
            'rows'       => [
              '1' => [
                'name' => 'مفعل' , 
                'id' => 1 , 
              ],
              '2' => [
                'name' => 'غير مفعل' , 
                'id' => 0 , 
              ],
            ] , 
            'input_name' => __('admin.phone_activation_status')  , 
        ] ,
        
    ]" 
>
  <x-slot name="extrabuttonsdiv">
    <a type="button" data-toggle="modal" data-target="#notify"
      class="btn bg-gradient-info mr-1 mb-1 waves-effect waves-light notify"
      data-id="all"><i class="feather icon-bell"></i> {{ __('admin.Send_notification') }}</a>
    {{-- <a type="button" data-toggle="modal" data-target="#mail"
      class="btn bg-gradient-success mr-1 mb-1 waves-effect waves-light mail"
      data-id="all"><i class="feather icon-mail"></i> {{ __('admin.Send_email') }}</a> --}}
  </x-slot>

    <x-slot name="tableContent">
        <div class="table_content_append">

        </div>
    </x-slot>
</x-admin.table>
  {{-- notify users model --}}
  <x-admin.NotifyAll route="{{ route('admin.clients.notify') }}" />
  {{-- notify users model --}}
@endsection

@section('js')
    <script src="{{asset('admin/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js')}}"></script>
    <script src="{{asset('admin/app-assets/js/scripts/forms/validation/form-validation.js')}}"></script>
    <script src="{{asset('admin/app-assets/vendors/js/extensions/sweetalert2.all.min.js')}}"></script>
    <script src="{{asset('admin/app-assets/js/scripts/extensions/sweet-alerts.js')}}"></script>
    @include('admin.shared.deleteAll')
    @include('admin.shared.deleteOne')
    @include('admin.shared.filter_js' , [ 'index_route' => url('admin/clients')])
    @include('admin.shared.notify')
    <script>
      $(document).ready(function(){
          $(document).on('click','.block_user',function(e){
              e.preventDefault();
              $.ajax({
                  url: '{{url("admin/clients/block")}}',
                  method: 'post',
                  data: { id : $(this).data('id')},
                  dataType:'json',
                  beforeSend: function(){
                      $(this).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>').attr('disable',true)
                  },
                  success: function(response){
                      Swal.fire({
                                  position: 'top-start',
                                  type: 'success',
                                  title: response.message,
                                  showConfirmButton: false,
                                  timer: 1500,
                                  confirmButtonClass: 'btn btn-primary',
                                  buttonsStyling: false,
                              })
                      setTimeout(function(){
                          window.location.reload()
                      }, 1000);
                  },
              });
  
          });
      });
  </script>
@endsection
