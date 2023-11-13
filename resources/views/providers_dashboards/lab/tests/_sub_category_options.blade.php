<option selected disabled>@lang('localize.pc_test_category')</option>
@foreach ($subCategories as $category)
    <option value="{{ $category->id }}">{{ $category->name }}</option>
@endforeach
