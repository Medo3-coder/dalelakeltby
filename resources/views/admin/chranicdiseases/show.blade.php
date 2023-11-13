@extends('admin.layout.master')

@section('content')
<!-- // Basic multiple Column Form section start -->
<section id="multiple-column-form">
    <div class="row match-height">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">{{__('admin.view') . ' ' . __('admin.chranicdiseases')}}</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form  class="show form-horizontal" >
                            <div class="col-12">
    

                                <div class="row">
                                    @foreach (languages() as $lang)
                               
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="first-name-column">{{__('site.name_'.$lang)}}</label>
                                            <div class="controls">
                                                @if ($lang == 'en')
                                                <input type="text" value="{{$chranicdiseases->getTranslations('name')[$lang] ?? '' }}"  name="name[{{$lang}}]" class="form-control">
                                                @else
                                                <input type="text" value="{{$chranicdiseases->getTranslations('name')[$lang]}}" name="name[{{$lang}}]" class="form-control" placeholder="{{__('site.write') . __('site.name_'.$lang)}}" required data-validation-required-message="{{__('admin.this_field_is_required')}}">
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach 
                                <div class="col-12 d-flex justify-content-center mt-3">
                                        <a href="{{ url()->previous() }}" type="reset" class="btn btn-outline-warning mr-1 mb-1">{{__('admin.back')}}</a>
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