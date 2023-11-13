@extends('providers_dashboards.layouts.dashboards.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('/') }}dashboard/css/select2.css" />

@endpush
@section('content')
    <main class="main-sec" id="main">
        <div class="container">
            <div class="side-heading">
                <h6>{{ __('store.Add a new feature') }}</h6>
                <div class="links-top-to">
                    <a href="{{ route('store.products') }}">{{ __('store.products') }}</a>  /
                    <span class="color-main">{{ __('store.Add an attribute to the product', ['name'=>$product->name]) }}</span>
                </div>
            </div>
            <form action="{{ route('store.products.features.update', $product['id']) }}" method="POST" enctype="multipart/form-data" id="form">
                @csrf
                <div class="card-ins">
                    <div class="card-white">
                        <h4 class="font_bold mb-4 spe-border">{{ __('store.Attribute data') }}</h4>
                        <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{ __('store.Attribute identification') }}</h6>
                            <select name="feature_id" id="feature_id" class="default2-select gr">
                                <option value selected disabled>{{ __('store.Choose a theme') }}</option>
                                @foreach($features as $feature)
                                    <option data-feature="{{$feature}}" value="{{$feature->id}}">{{$feature->getTranslation('name', lang())}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-12">
                            <button class="add-mmore up" onclick="addFeatures()" type="button">اضافة</button>
                        </div>
                    </div>

                    @if($product->productfeatures()->count()>0)
                        @foreach($product->productfeatures as $feature)
                            <div class="card-white mt-3 container mm-auto">
                                <input type="hidden" class="feature_id" name="feature_id[]" value="{{ $feature->feature?->id }}" >
                                <div class="col-12 d-flex align-items-center justify-content-between spe-border mb-4">
                            <h5 class="font_bold">{{ $feature->feature?->name }}</h5>
                            <div class="remove-mn" onclick="removeFeature(this, '{{ $feature->id }}')"><i class="fa-solid fa-xmark"></i></div>
                        </div>
                                <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{__('store.Choose properties for an attribute')}} ({{ $feature->feature?->name }}) </h6>
                            <div class="input_select">
                                <select class="select2 features multiple_select feature_{{ $feature->feature->id }}"  name="proparties[{{$feature->feature->id}}][]" multiple="multiple">
                                    @foreach ( $feature->feature->properities as $properity)
                                        <option {{ in_array( $properity->id , $feature->productfeatureproperities()->pluck('properity_id')->toArray() ) ? 'selected' : ''}} value="{{$properity->id}}">{{$properity->getTranslation('name', lang())}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                            </div>
                        @endforeach
                    @endif

                </div>

                <div class="col-12">
                    <button type="submit" id="submit" class="submit up mt-3 mr-2 text-center">{{ $product->productfeatures()->count() > 0 ? __('store.Features update') : __('store.Add confirmation')}}</button>
                </div>
            </form>

        </div>

    </main>


@endsection
@push('js')
    <script src="{{ asset('/') }}dashboard/js/alerts.js" ></script>
    <script src="{{ asset('/') }}dashboard/js/select2.js"></script>
    <script>
        let select2s = document.querySelector(".select2");
        if (select2s) {
            $(document).ready(function () {
                $(".select2").select2({
                    placeholder: {
                        id: '-1',
                        text: '{{ __('store.Chose themes') }}'
                    }
                });
            });
        }


        $('#form').on('submit', function (){
            event.preventDefault();
            var features = $('.features');
            var checkValue = features.filter(function() { return this.value === ''; });
            var check = true;

            if(features.length === 0){
                check = false;
                Swal.fire({
                    icon: 'info',
                    iconColor: '#2f71b3',
                    title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, you must choose at least one attribute') }}' +'</h5>',
                    showConfirmButton: true,
                    confirmButtonText: '{{ __('store.ok') }}',
                    timer: 3000
                })
            }

            if(checkValue.length > 0){
                check = false;
                Swal.fire({
                    icon: 'info',
                    iconColor: '#2f71b3',
                    title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, fields should not be left blank') }}' +'</h5>',
                    showConfirmButton: true,
                    confirmButtonText: '{{ __('store.ok') }}',
                    timer: 3000
                })

            }

            if(check === true){
                $.ajax({
                    url: '{{ route('store.products.features.update', $product['id']) }}',
                    method: 'post',
                    data: new FormData($(this)[0]),
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {

                        Swal.fire({
                            icon: 'info',
                            iconColor: '#2f71b3',
                            title: '<h5 class="font_bold">'+ '{{ __('store.Congratulations!') . ' ' . __('store.Product attributes added successfully, please select attribute groups') }}' +'</h5>',
                            showConfirmButton: true,
                            confirmButtonText: '{{ __('store.ok') }}',
                            timer: 3000
                        });


                        setTimeout(function(){
                            window.location.replace(response.url)
                        }, 1000);
                    }
                });
            }



        });

        function removeFeature(el, id = null){
            var section = $(el);

            Swal.fire({
                icon: 'info',
                iconColor: '#2f71b3',
                title: '<h5 class="font_bold">'+ "{{ __('store.Do you want to delete this feature?') }}" +'</h5>',
                showDenyButton: true,
                showCancelButton: true,
                showConfirmButton: false,
                denyButtonText: '{{ __('store.delete') }}',
                cancelButtonText:'{{ __('store.cancel') }}'
            }).then((result)=>{
                if (result.isDenied) {
                    var msgSuccess = '{{ __('store.Congratulations!') . ' ' . __('store.The attribute has been deleted successfully') }}';
                    var iconSuccess = 'success';
                    var colorSuccess = '#2f71b3';

                    var msgError = '{{ __('store.Sorry, something went wrong') }}';
                    var iconError = 'error';
                    var colorError = '#ff0000';

                    if (id === null){
                        section.parents('.card-white').remove();
                        Swal.fire({
                        icon: iconSuccess,
                            iconColor: colorSuccess,
                            title: '<h5 class="font_bold">'+ msgSuccess +'</h5>',
                            showConfirmButton: true,
                            confirmButtonText: '{{ __('store.ok') }}',
                            timer: 2000
                    })
                    }else {
                        $.ajax({
                            url: '{{ route('store.products.features.delete', $product['id']) }}',
                            method: 'post',
                            data: {
                                _token:'{{ csrf_token() }}',
                                _method:'DELETE',
                                id:id
                            },
                            dataType: 'json',
                            success: function(response) {
                                section.parents('.card-white').remove();
                                Swal.fire({
                                    icon: iconSuccess,
                                    iconColor: colorSuccess,
                                    title: '<h5 class="font_bold">'+ msgSuccess +'</h5>',
                                    showConfirmButton: true,
                                    confirmButtonText: '{{ __('store.ok') }}',
                                    timer: 2000
                                })

                            },error: function (xhr){
                                Swal.fire({
                                    icon: iconError,
                                    iconColor: colorError,
                                    title: '<h5 class="font_bold">'+ msgError +'</h5>',
                                    showConfirmButton: true,
                                    confirmButtonText: '{{ __('store.ok') }}',
                                    timer: 2000
                                })

                            }
                        });

                    }


                }
            });

        }

    </script>

    <script>

        function addFeatures(){
            event.preventDefault();
            var featureSelect = $('#feature_id');
            console.log(featureSelect.val());
            if(featureSelect.val() === '' || featureSelect.val() === null){
                Swal.fire({
                    icon: 'info',
                    iconColor: '#2f71b3',
                    title: '<h5 class="font_bold">'+ '{{ __('store.Sorry, at least one attribute must be selected') }}' +'</h5>',
                    showConfirmButton: true,
                    confirmButtonText: '{{ __('store.ok') }}',
                    timer: 3000
                })
            }else {
                var selected        = $('#feature_id option:selected');
                var feature         = selected.data('feature')

                if ($('.feature_'+feature.id).length > 0) {
                    Swal.fire({
                        icon: 'info',
                        iconColor: '#2f71b3',
                        title: '<h5 class="font_bold">'+ '{{ __('store.The feature has been added previously') }}' +'</h5>',
                        showConfirmButton: true,
                        confirmButtonText: '{{ __('store.ok') }}',
                        timer: 3000
                    })
                }else{
                    var options = '' ;

                    var i = 0;
                    @foreach($properties as $properity)
                        if(featureSelect.val() == '{{ $properity['feature_id'] }}'){
                        options += `<option value="{{ $properity['id']}}" ${ i === 0 ? 'selected' : '' }>{{ $properity->getTranslation('name', lang()) }}</option>`
                        i++;
                    }
                    @endforeach


                    $('.card-ins').append(`
    <div class="card-white mt-3 container mm-auto">
                                <div class="col-12 d-flex align-items-center justify-content-between spe-border mb-4">
                            <h5 class="font_bold">(${feature.name.ar})</h5>
                            <input type="hidden" class="feature_id" name="feature_id[]" value="${feature.id}" >
                            <div class="remove-mn" onclick="removeFeature(this)"><i class="fa-solid fa-xmark"></i></div>
                        </div>
                                <div class="mb-3 main-inp-cont col-12 col-lg-8">
                            <h6 class="fontBold mainColor font14">{{__('store.Choose properties for an attribute')}} (${feature.name.ar})</h6>
                            <div class="input_select">
                                <select class="features select2 multiple_select feature_${feature.id}" name="proparties[${feature.id}][]" multiple="multiple">
                                    ${options}
                                </select>
                </div>
            </div>
                </div>

                `)
                    $('.select2').select2({
                        placeholder: {
                            id: '-1',
                            text: '{{ __('store.Chose themes') }}'
                        }
                    })
                }
            }
        }




    </script>

@endpush
