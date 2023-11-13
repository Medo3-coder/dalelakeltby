<table class="table text-center" style="width: 100%">
    <thead class="table-head">
        <tr>
            <th class="font10">@lang('site.serial_number')</th>
            <th class="font10">{{ __('store.offer_num') }}</th>
            <th class="font10">{{ __('store.offer_image') }}</th>
            <th class="font10">{{ __('store.offer_name') }}</th>
            <th class="font10">{{ __('store.offer_type') }}</th>
            <th class="font10">{{ __('store.end_offer') }}</th>
            <th class="font10">{{ __('store.Added date') }}</th>
            <th class="font10"></th>
            <th class="font10"></th>
        </tr>
    </thead>
    <tbody data-class-name="table-body">
        @if ($offers->count() != 0)

            @foreach ($offers as $key => $offer)
                <tr>
                    <td class="font12">{{ '#' . $key + 1 }}</td>

                    <td class="font12" >
                        <span class="d-flex justify-content-center align-items-center">{{ $offer->offer_num }}</span>
                    </td>

                    <td class="font12" >
                        <img class="table-spe-img" src="{{ $offer->image }}" alt="">
                    </td>
                    <td class="font12" >
                        <span class="d-flex justify-content-center align-items-center">{{ $offer->name }}</span>
                    </td>

                    <td class="font12" >
                        <span class="d-flex justify-content-center align-items-center">{{ $offer->type == 'products' ? __('store.products') : __('store.equipment') }}</span>
                    </td>



                    <td class="font12">
                        <span class="d-flex justify-content-center align-items-center">{{ Carbon\Carbon::parse($offer->end_offer)->translatedFormat('j F Y') }}</span>
                    </td>
                    <td class="font12">
                  <span
                  ><a href="{{ route('store.offers.show', $offer->id) }}" class="font_bold color-main"
                      >{{ __('store.Offer details') }}</a
                      ></span
                  >
                    </td>

                    <td  class="drop-co"><i class="fa-solid fa-ellipsis drop-icon drop-icon" onclick="sm(this)"></i>
                        <ul class="drop-down dropDownData">
                            <li>
                                <a href="{{ route('store.offers.edit', $offer->id) }}" >
                                    <span class="icon-co"><i class="fa-solid fa-pen-to-square"></i></span>{{ __('store.edit') }}</a>
                            </li>
                            <li>
                                <a href="#" class="delete-row" data-val="{{ $offer->id }}">
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
@if ($offers->count() > 0 && $offers instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="pag-all d-flex align-items-center justify-content-between" >
        <div class="pag-right">@lang('site.show_results_from') {{ $offers->firstItem() }}-{{ $offers->total() }}</div>
        <div class="pag-left">{{$offers->links()}}</div>
    </div>
@endif

    @if ($offers->count() == 0)
        @include('shared.empity')
    @endif