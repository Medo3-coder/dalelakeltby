@extends('admin.layout.master')

@section('content')
    <!-- // Basic multiple Column Form section start -->
    <section id="multiple-column-form">
        <div class="row match-height">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ __('admin.view') . ' ' . __('admin.labcategory') }}</h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="show form-horizontal">
                                <div class="row">
                                    @foreach (languages() as $lang)
                                        <div class="col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="first-name-column">{{ __('site.name_' . $lang) }}</label>
                                                <div class="controls">
                                                    <input type="text"
                                                        value="{{ $labcategory->getTranslations('name')[$lang] ?? '' }}"
                                                        name="name[{{ $lang }}]" class="form-control">

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach


                                    <div class="col-md-6 col-6">
                                        <div class="form-group">
                                            <label for="first-name-column">{{ __('admin.has_targeted_bodies') }}</label>
                                            <div class="controls">
                                                <select name="has_targeted_body" class="select2 form-control" required
                                                    data-validation-required-message="{{ __('admin.this_field_is_required') }}">
            
                                                    <option {{$labcategory->has_targeted_body ? 'selected' : ''}} value="1">
                                                        {{ __('admin.yes') }}</option>

                                                    <option {{!$labcategory->has_targeted_body ? 'selected' : ''}} value="0">
                                                        {{ __('admin.no') }}</option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>



                                    <div class="col-12 d-flex justify-content-center mt-3">
                                        <a href="{{ url()->previous() }}" type="reset"
                                            class="btn btn-outline-warning mr-1 mb-1">{{ __('admin.back') }}</a>
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
