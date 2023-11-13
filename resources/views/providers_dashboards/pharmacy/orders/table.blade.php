<table class="table text-center" style="width: 100%">
    <thead class="table-head">
        <tr>
            <th class="font10">@lang('site.serial_number')</th>
            <th class="font10">@lang('site.order_num')</th>
            <th class="font10">@lang('localize.store_name')</th>
            <th class="font10">@lang('localize.store_address')</th>
            <th class="font10">@lang('localize.order_date')</th>
            <th class="font10"></th>
        </tr>
    </thead>
    <tbody data-class-name="table-body">
        @if ($orders->count() != 0)
            @foreach ($orders as $key => $order)
                <tr>
                    <td class="font12">{{ ++$key }}</td>

                    <td class="font12">#{{ $order->order_num }}</td>

                    <td class="font12">
                        <span class="fontBold">{{ $order->store->name }}</span>
                    </td>

                    <td class="font12">
                        <span class="text-secondary">{{ $order->store->branches->first()->address }}</span>
                    </td>

                    <td class="font12">
                        <span
                            class="d-flex justify-content-center align-items-center">{{ $order->created_at->format('d-m-Y ') }}</span>
                    </td>
                    <td class="font12">
                        <a class="d-flex justify-content-center align-items-center"
                            href="{{ route('pharmacy.myOrders.details', $order->id) }}">@lang('site.order_details')</a>
                    </td>

                    {{-- <td class="font12">
                        <button type="button" class="refuse_order table-btn-spe danger-bg up danger-h"
                            data-toggle="modal" data-target="#staticBackdrop"
                            data-order_id="{{ $order->id }}">
                            @lang('site.cancel_order')
                        </button>
                    </td>
                    <td class="font12">
                        <button type="button" class="accept_order table-btn-spe main-bg up"
                            data-url="{{ url('lab/accept-order/' . $order->id) }}">
                            @lang('site.accept_order')
                        </button>
                    </td> --}}
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if ($orders->count() > 0 && $orders instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="pag-all d-flex align-items-center justify-content-between">
        <div class="pag-right">@lang('site.show_results_from') {{ $orders->firstItem() }}-{{ $orders->total() }}</div>
        <div class="pag-left">{{ $orders->links() }}</div>
    </div>
@endif

@if ($orders->count() == 0)
    @include('shared.empity')
@endif
