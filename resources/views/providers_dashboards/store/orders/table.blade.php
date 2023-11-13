<table class="table text-center" style="width: 100%">
    <thead class="table-head">
        <tr>
            <th class="font10">@lang('site.serial_number')</th>
            <th class="font10">{{ __('store.order number') }}</th>
            <th class="font10">{{ __('store.customer name') }}</th>
            <th class="font10">{{ __('store.customer address') }}</th>
            <th class="font10">{{ __('store.The date of application') }}</th>
            <th class="font10"></th>
        </tr>
    </thead>
    <tbody data-class-name="table-body">
        @if ($orders->count() != 0)

            @foreach ($orders as $key => $order)
                <tr>
                    <td class="font12">{{ '#' . $key + 1 }}</td>

                    <td>
                        <span class="d-flex justify-content-center align-items-center">{{ $order->order_num }}</span>
                    </td>
                    <td>
                        <span class="d-flex justify-content-center align-items-center">{{ getUser($order)->name }}</span>
                    </td>

                    <td>
                        <span class="d-flex justify-content-center align-items-center">{{ \Illuminate\Support\Str::limit($order->address, 50) }}</span>
                    </td>

                    <td>
                        <span class="d-flex justify-content-center align-items-center">{{ Carbon\Carbon::parse($order->created_at)->translatedFormat('j F Y') }}</span>
                    </td>


                    <td>
                        <a href="{{ route('store.orders.show', $order['id']) }}" class="font_bold color-main">
                            <span class="">{{ __('store.Order details') }}</span>
                        </a>
                    </td>






                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if ($orders->count() > 0 && $orders instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="pag-all d-flex align-items-center justify-content-between" >
        <div class="pag-right">@lang('site.show_results_from') {{ $orders->firstItem() }}-{{ $orders->total() }}</div>
        <div class="pag-left">{{$orders->links()}}</div>
    </div>
@endif

    @if ($orders->count() == 0)
        @include('shared.empity')
    @endif