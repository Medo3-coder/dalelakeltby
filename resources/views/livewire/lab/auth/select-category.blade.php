<div>
    <!-- <form action="#"> -->
    <h5>@lang('localize.main_category')</h5>
    <div class="inputs-rad">

        @foreach ($categories as $key => $category)
            <div wire:key="lab-category{{ $key }}" class="input-rad" data-radio="show-hide1">
                <input type="checkbox" name="category_ids[]" value="{{ $category->id }}" wire:model="category_ids"
                    id="radio{{ $key }}" value="show-me1" class="radio-spe" />
                <label for="radio{{ $key }}">{{ $category->name }}</label>
            </div>
        @endforeach

    </div>
    <div class="error_show error_labCategories"></div>

    @if (count($category_ids))
        <div class="branshes">
            <h5 class="mb-5">@lang('localize.sub_categories')</h5>
            @foreach ($categories->whereIn('id', $category_ids) as $selectedKey => $selectedCategory)
                <div wire:key="selectedKey{{ $selectedKey }}" class="show-spe show-mm d-block company-title mB-4 mt-4"
                    id="show-hide1">

                    @foreach ($categoriesCounters[$selectedKey] as $index)
                        <div class="mt-3" wire:key="new_one_of_category_type{{ $selectedKey }}_{{ $index }}">
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">
                                    @lang('localize.cat_type') {{ $selectedCategory->name }}
                                </h6>
                                <input type="hidden"
                                    name="labCategories[{{ $selectedKey }}][{{ $index }}][lab_category_id]"
                                    value="{{ $selectedCategory->id }}">
                                <select class="default_input-spe another-sh-select"
                                    name="labCategories[{{ $selectedKey }}][{{ $index }}][sub_category_id]"
                                    id="">
                                    <option value="" selected disabled>
                                        @lang('localize.please_choose_type') {{ $selectedCategory->name }}
                                    </option>


                                    @foreach ($selectedCategory->children as $child)
                                        <option wire:key="child{{ $selectedKey }}" value="{{ $child->id }}">
                                            {{ $child->name }}</option>
                                    @endforeach


                                </select>
                                <div
                                    class="error_show error_labCategories.{{ $selectedKey }}.{{ $index }}.sub_category_id">
                                </div>

                            </div>
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">
                                    @lang('localize.cat_price') {{ $selectedCategory->name }}
                                </h6>
                                <div class="form__label">
                                    <input class="default_input cl-class-sle" type="number"
                                        name="labCategories[{{ $selectedKey }}][{{ $index }}][price]"
                                        placeholder=" @lang('localize.pe_cat_price') {{ $selectedCategory->name }}" />
                                    <label class="float__label" for="">@lang('localize.pe_cat_price')
                                        {{ $selectedCategory->name }}</label>
                                </div>
                                <div
                                    class="error_show error_labCategories.{{ $selectedKey }}.{{ $index }}.price">
                                </div>

                            </div>
                            {{--  'lab_category_id', 'sub_category_id', 'price', 'name', 'unit', 'normal_range'  --}}
                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">
                                    @lang('localize.the_unit')
                                </h6>
                                <div class="form__label">
                                    <input name="labCategories[{{ $selectedKey }}][{{ $index }}][unit]"
                                        class="default_input cl-class-sle" type="text"
                                        placeholder="@lang('localize.pe_unit') " />
                                    <label class="float__label" for="">@lang('localize.pe_unit')</label>
                                </div>
                                <div
                                    class="error_show error_labCategories.{{ $selectedKey }}.{{ $index }}.unit">
                                </div>

                            </div>

                            <div class="mb-3 main-inp-cont">
                                <h6 class="fontBold mainColor font14">
                                    @lang('localize.range')
                                </h6>
                                <div class="form__label">
                                    <input
                                        name="labCategories[{{ $selectedKey }}][{{ $index }}][normal_range]"
                                        class="default_input cl-class-sle" type="text"
                                        placeholder="@lang('localize.pe_range') " />
                                    <label class="float__label" for="">@lang('localize.pe_range')</label>
                                </div>
                                <div
                                    class="error_show error_labCategories.{{ $selectedKey }}.{{ $index }}.normal_range">
                                </div>

                            </div>

                            @if ($selectedCategory->has_targeted_body)
                                <h5 class="mb-5">{{ __('admin.target') }}</h5>
                                <div class="all-colomns">

                                    @foreach ($bodyAreas as $areaKey => $Area)
                                        <div class="colomn1"
                                            wire:key="areakey{{ $selectedKey . $selectedKey . $areaKey . '_' . $index }}">

                                            <div class="default-row mb-2">
                                                <input
                                                    name="labCategories[{{ $selectedKey }}][{{ $index }}][targeted_bodies][]"
                                                    id="areakey{{ $selectedKey . $selectedKey . '_' . $areaKey . '_' . $index }}"
                                                    type="checkbox" value="{{ $Area->id }}" />
                                                <label
                                                    for="areakey{{ $selectedKey . $selectedKey . '_' . $areaKey . '_' . $index }}"
                                                    style="min-width: 100px" class="default-row-text">
                                                    {{ $Area->name }}
                                                </label>
                                            </div>


                                        </div>
                                    @endforeach
                                    <div
                                        class="error_show error_labCategories.{{ $selectedKey }}.{{ $index }}.targeted_bodies">
                                    </div>
                                </div>
                            @endif
                        </div>

                        @if ($index !== 0)
                            <div class="btn btn-danger">
                                <div wire:click="removeCategoryType({{ $selectedKey }} ,{{ $index }})"
                                    class="plus-add2"><i class="fa fa-trash"></i></div>
                            </div>
                        @endif
                    @endforeach

                    <div class="work-plus-icon2 cl-click click-1">
                        <div wire:click="addCategoryType({{ $selectedKey }})" class="plus-add2"><i
                                class="fa fa-plus"></i></div>
                    </div>

                </div>
            @endforeach
        </div>
        <!-- </form> -->
    @endif
</div>
