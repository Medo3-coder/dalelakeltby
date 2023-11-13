<table class="table text-center" style="width: 100%">
    <thead class="table-head">
        <tr>
            <th class="font10">@lang('site.serial_number')</th>
            <th class="font10">{{ __('store.Image') }}</th>
            <th class="font10">{{ __('store.product_name_ar') }}</th>
            <th class="font10">{{ __('store.product_name_en') }}</th>
            <th class="font10">{{ __('store.Product price') }}</th>
            <th class="font10">{{ __('store.Added date') }}</th>
            <th class="font10"></th>
        </tr>
    </thead>
    <tbody data-class-name="table-body">
        @if ($products->count() != 0)

            @foreach ($products as $key => $product)
                <tr>
                    <td class="font12">{{ '#' . $key + 1 }}</td>

                    <td class="font12"><img class="table-spe-img" src="{{ $product->image }}" alt=""></td>
                    <td>
                        <span class="d-flex justify-content-center align-items-center">{{ $product->getTranslation('name', 'ar') }}</span>
                    </td>
                    <td>
                        <span class="d-flex justify-content-center align-items-center">{{ $product->getTranslation('name', 'en') }}</span>
                    </td>

                    <td>
                        <span class="d-flex justify-content-center align-items-center">{!! $product->display_price() !!}</span>
                    </td>

                    <td class="font12">
                        <span class="d-flex justify-content-center align-items-center">{{ Carbon\Carbon::parse($product->created_at)->translatedFormat('j F Y') }}</span>
                    </td>
                    <td  class="drop-co"><i class="fa-solid fa-ellipsis drop-icon drop-icon" onclick="sm(this)"></i>
                        <ul class="drop-down dropDownData">
                                <li>
                                    <a href="{{ route('store.products.additions', $product->id) }}" >
                                        <span class="icon-co"><i class="fa-regular fa-square-plus"></i></span>{{ __('store.additions') }}</a>
                                </li>

                            <li>
                                <a href="{{ route('store.products.show', $product->id) }}" >
                                    <span class="icon-co"><i class="fa fa-eye"></i></span>{{ __('store.show') }}</a>
                            </li>

                            <li>
                                <a href="{{ route('store.products.edit', $product->id) }}" >
                                    <span class="icon-co"><i class="fa-solid fa-pen-to-square"></i></span>{{ __('store.edit') }}</a>
                            </li>
                            <li>
                                <a href="#" class="delete-row" data-val="{{ $product->id }}">
                                <span class="icon-co">
                                    <i class="fa-solid fa-trash"></i>
                                </span>
                                    {{ __('store.delete') }}
                                </a>
                            </li>

                        </ul>
                    </td>




                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if ($products->count() > 0 && $products instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="pag-all d-flex align-items-center justify-content-between" >
        <div class="pag-right">@lang('site.show_results_from') {{ $products->firstItem() }}-{{ $products->total() }}</div>
        <div class="pag-left">{{$products->links()}}</div>
    </div>
@endif

    @if ($products->count() == 0)
        @include('shared.empity')
    @endif