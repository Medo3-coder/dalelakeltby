@extends('admin.layout.master')

@section('content')
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.view') . ' ' . __('admin.pharmacies') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="show form-horizontal">
                                <div class="form-body">

                                    <div class="row">


                                        <div class="imgMontg col-12 text-center">

                                            <div class="dropBox d-flex">
                                                @foreach ($images as $image)
                                                    <div class="textCenter">
                                                        <div class="imagesUploadBlock">
                                                            <label class="uploadImg">
                                                                <span><i class="feather icon-image"></i></span>
                                                                <input type="file" accept="image/*" name="images[]" class="imageUploader">
                                                            </label>
                                                            <div class="uploadedBlock">
                                                                <img src="{{$image->image}}">
                                                                {{-- <button class="delete-image" data-id="{{$image->id}}"><i class="feather icon-trash text-danger"></i></button> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>

                                            
                                        </div>


                                        <div class="col-md-6 col-6">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.address') }}</label>
                                                <div class="controls">
                                                    <input type="text" name="address" value="{{ $row->address }}"
                                                        class="form-control" placeholder="{{ __('admin.write_the_name') }}">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-6 col-6">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.name') }}</label>
                                                <div class="controls">
                                                    <input type="text" name="name" value="{{ $row->name }}"
                                                        class="form-control"
                                                        placeholder="{{ __('admin.write_the_email') }}">
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-md-6 col-6">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('admin.comerical_record') }}</label>
                                                <div class="controls">
                                                    <input type="text" name="comerical_record"
                                                        value="{{ $row->comerical_record }}" class="form-control">
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    @if (count($timings) != 0)
                                    @foreach ($timings as $timing)
                                        <div class="times-cont">
                                            <div class="container time m-auto">
                                                <div class="row align-items-center">
                                                    <div class="col-md  p-1">
                                                        <label class="bold">{{ __('admin.day') }}
                                                        </label>
                                                        <select name="days[]" required
                                                            data-validation-required-message="{{ __('admin.this_field_is_required') }}"
                                                            class="form-control border no-arrow">
                                                            <option value="{{ $timing->day }}"
                                                                selected>
                                                                {{ trans('admin.' . $timing->day) }}
                                                            </option>
                                                            <option value="saturday">
                                                                {{ __('admin.saturday') }}</option>
                                                            <option value="sunday">
                                                                {{ __('admin.sunday') }}</option>
                                                            <option value="monday">
                                                                {{ __('admin.monday') }}</option>
                                                            <option value="tuesday">
                                                                {{ __('admin.tuesday') }}</option>
                                                            <option value="wednesday">
                                                                {{ __('admin.wednesday') }}
                                                            </option>
                                                            <option value="thursday">
                                                                {{ __('admin.thursday') }}
                                                            </option>
                                                            <option value="friday">
                                                                {{ __('admin.friday') }}</option>
                                                        </select>
                                                    </div>

                                                    <div class="col-md  p-1 ">
                                                        <label
                                                            class="bold">{{ __('admin.from') }}
                                                        </label>
                                                        <input type="time" required
                                                            data-validation-required-message="{{ __('admin.this_field_is_required') }}"
                                                            value="{{ $timing->from }}"
                                                            class="form-control  border round5 w-100"
                                                            name="from[]" id="">
                                                    </div>

                                                    <div class="col-md  p-1">
                                                        <label
                                                            class="bold">{{ __('admin.to') }}</label>
                                                        <input type="time" required
                                                            data-validation-required-message="{{ __('admin.this_field_is_required') }}"
                                                            value="{{ $timing->to }}"
                                                            class="form-control  border round5 w-100"
                                                            name="to[]" id="">
                                                    </div>

                                                    <div class="col-md-1  p-1">
                                                        <div
                                                            class="d-flex align-items-center flex-column">
                                                            <label class="bold sn"
                                                                style="color: #fff;"></label>
                                                            <a type="button"
                                                                class="button-error material-button"
                                                                onclick="removeTime(this)"><i
                                                                    class="fa fa-times"></i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    @endif

                                    <div class="col-md-12 col-12 ">
                                        <div class="form-group  pl-5 pr-5 mt-4 position-relative">
                                            <label for="" class="d-block mb-3 siz13 font-weight-bolder">{{awtTrans('تحديد الموقع')}}</label>
                                            <div class="controls">
                                                {{-- <input  class="form-control position-absolute w-25" style="z-index: 11111; top:14%; left:7%" id="searchTextField" value="" placeholder="{{awtTrans('تحديد موقعك')}}"> --}}
                                            </div>
                                            <div id="map" style="height: 400px; margin-top: 20px">
                                            </div>
                                            <input type="hidden" id="lat" name="lat" value="{{$row->lat}}">
                                            <input type="hidden" id="lng" name="lng" value="{{$row->lng}}">
                                        </div>
                                    </div>




                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <a href="{{ url()->previous() }}" type="reset"
                                            class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
                                    </div>

                                </div>

                                {{-- </div> --}}
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


@include('admin.partials.map', ['lat' => $row->lat, 'lng' => $row->lng, 'draggable' => false])
@endsection
