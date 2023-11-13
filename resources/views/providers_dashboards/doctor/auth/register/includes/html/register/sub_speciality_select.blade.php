@if (count($subspecialities) > 0)
    <h6 class="fontBold mainColor font14">
        @lang('localize.sub_speciality')
    </h6>
    <div class="form__label">
        <select  name="category_id" class="default_input">
            <option selected disabled>@lang('localize.pc_sub_speciality')</option>
            @foreach ($subspecialities as $category)
            <option {{ isset($doctor) && $doctor->category_id == $category->id ? 'selected' : '' }} value="{{$category->id}}">{{$category->name}}</option>
            @endforeach
        </select>
    </div>
@endif
