<table class="table text-center" style="width: 100%">
    <thead class="table-head">
        <tr>
            <th class="font10">@lang('site.serial_number')</th>
            {{-- <th class="font10">@lang('site.image')</th> --}}
            <th class="font10">@lang('localize.name_in_english')</th>
            <th class="font10">@lang('localize.price')</th>
            <th class="font10">@lang('localize.price_after_discount')</th>
            <th class="font10">@lang('localize.addition_date')</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody data-class-name="table-body">
        @if ($tests->count() != 0)
            @foreach ($tests as $key => $test)
                <tr>
                    <td class="font12">{{++$key}}</td>

                    {{-- <td class="font12"><img class="table-spe-img" src="imgs/NoPath.png" alt=""></td> --}}

                    <td class="font12">
                        <span class="fontBold">cbc</span>
                    </td>

                    <td class="font12">
                        <span class="text-secondary">60.00 دينار</span>
                    </td>
                    <td class="font12">
                        <span class="text-secondary">60.00 دينار</span>
                    </td>
                    <td class="font12">
                        <span class="text-secondary">3 يناير 2023</span>
                    </td>
                    <td class="font12">
                        <span class="text-secondary"><a href="all-results.html" class="table-spe-l up"><i
                                    class="fa-solid fa-plus"></i> مفردات التحليل</a></span>
                    </td>

                    <td class="drop-co"><i class="fa-solid fa-ellipsis drop-icon drop-icon" onclick="sm(this)"></i>
                        <ul class="drop-down dropDownData">
                            <li>
                                <a href="Modify.html">
                                    <span class="icon-co"><i class="fa-solid fa-pen-to-square"></i></span>تعديل</a>
                            </li>
                            <li>
                                <a href="#" data-toggle="modal" data-target="#searchMODEL" data-dismiss="modal">
                                    <span class="icon-co">
                                        <i class="fa-solid fa-trash"></i>
                                    </span>
                                    حذف
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
    <div class="no-data d-flex justify-content-center">
        <img src="{{ asset('/') }}dashboard/imgs/empty.png" alt="">
    </div>
@endif
