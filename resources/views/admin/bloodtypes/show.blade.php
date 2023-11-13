@extends('admin.layout.master')

@section('content')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('admin.view') . ' ' . __('admin.bloodtype')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form  class="show form-horizontal" >
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="first-name-column">{{__('admin.name')}}</label>
                                    <div class="controls">
                                        <input type="text" name="name" value="{{$bloodtype->name}}"
                                            class="form-control" placeholder="{{__('admin.write_the_name')}}"
                                            required
                                            data-validation-required-message="{{__('admin.this_field_is_required')}}">
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
        $('.show input').attr('disabled' , true)
        $('.show textarea').attr('disabled' , true)
        $('.show select').attr('disabled' , true)
    </script>
@endsection