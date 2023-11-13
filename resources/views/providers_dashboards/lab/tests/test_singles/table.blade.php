<table class="table text-center" style="width: 100%">
    <thead class="table-head">
        <tr>
            <th class="font10">@lang('site.serial_number')</th>
            {{-- <th class="font10">@lang('site.image')</th> --}}
            <th class="font10">@lang('admin.name')</th>
            <th class="font10">@lang('localize.price')</th>
            <th class="font10">@lang('localize.normal_range')</th>
            <th class="font10">@lang('localize.unit')</th>

            {{--  <th class="font10">@lang('localize.price_after_discount')</th>  --}}
            <th class="font10">@lang('localize.addition_date')</th>
            {{--  <th></th>  --}}
            <th></th>
        </tr>
    </thead>
    <tbody data-class-name="table-body">
        @if ($tests->count() != 0)
            @foreach ($tests as $key => $test)
                <tr>
                    <td class="font12">{{ ++$key }}</td>

                    {{-- <td class="font12"><img class="table-spe-img" src="imgs/NoPath.png" alt=""></td> --}}

                    <td class="font12">
                        <span class="fontBold">{{ $test->name }}</span>
                    </td>

                    <td class="font12">
                        <span class="text-secondary">{{ $test->price }}</span>
                    </td>
                    <td class="font12">
                        <span class="text-secondary">{{ $test->normal_range }}</span>
                    </td>
                    <td class="font12">
                        <span class="text-secondary">{{ $test->unit }}</span>
                    </td>
                    <td class="font12">
                        <span class="text-secondary">{{ $test->created_at ?: ' --' }}</span>
                    </td>
                    {{--  <td class="font12">
                        <span class="text-secondary">3 يناير 2023</span>
                    </td>  --}}
                    {{--  <td class="font12">
                        <span class="text-secondary"><a
                                href="{{ route('lab.medicalTests.tests.index', ['test' => $test->id]) }}"
                                class="table-spe-l up"><i class="fa-solid fa-plus"></i> @lang('localize.test_single')</a></span>
                    </td>  --}}

                    <td class="drop-co"><i class="fa-solid fa-ellipsis drop-icon drop-icon" onclick="sm(this)"></i>
                        <ul class="drop-down dropDownData">
                            <li>
                                <a
                                    href="{{ route('lab.medicalTests.tests.edit', ['id' => $test->id, 'test' => $test->sub_category_lab_id]) }}">
                                    <span class="icon-co"><i
                                            class="fa-solid fa-pen-to-square"></i></span>@lang('admin.update')</a>
                            </li>
                            <li>
                                <a href="#" class="delete_test"
                                    data-url="{{ route('lab.medicalTests.tests.delete', ['id' => $test->id, 'test' => $test->sub_category_lab_id]) }}">
                                    <span class="icon-co">
                                        <i class="fa-solid fa-trash"></i>
                                    </span>
                                    @lang('doctor.delete')
                                </a>
                            </li>

                        </ul>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if ($tests->count() > 0 && $tests instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="pag-all d-flex align-items-center justify-content-between">
        <div class="pag-right">@lang('site.show_results_from') {{ $tests->firstItem() }}-{{ $tests->total() }}</div>
        <div class="pag-left">{{ $tests->links() }}</div>
    </div>
@endif

@if ($tests->count() == 0)
    @include('shared.empity')
@endif
