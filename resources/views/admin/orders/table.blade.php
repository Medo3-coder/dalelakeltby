<div class="position-relative">
    {{-- table loader  --}}
    <div class="table_loader" >
        {{__('admin.loading')}}
    </div>
    {{-- table loader  --}}
    
    {{-- table content --}}
    <table class="table " id="tab">
        <thead>
            <tr>
                <th>
                    <label class="container-checkbox">
                        <input type="checkbox" value="value1" name="name1" id="checkedAll">
                        <span class="checkmark"></span>
                    </label>
                </th>
                <th>{{__('site.serial_number')}}</th>
                <th>{{__('store.order number')}}</th>
                <th>{{__('store.store_name')}}</th>
                <th>{{ __('store.customer name') }}</th>
                <th>{{ __('store.customer address') }}</th>
                <th>{{ __('store.The date of application') }}</th>
                <th>{{__('admin.control')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $key => $order)
                <tr class="delete_row">
                    <td class="text-center">
                        <label class="container-checkbox">
                        <input type="checkbox" class="checkSingle" id="{{ $order->id }}">
                        <span class="checkmark"></span>
                        </label>
                    </td>
                    <td>{{ '# ' . $key + 1 }}</td>
                    <td>{{ $order->order_num }}</td>
                    <td>{{ optional($order->store)->name }}</td>
                    <td>{{ optional(getUser($order))->name }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($order->address, 50) }}</td>
                    <td>{{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}</td>

                    
                    <td class="product-action"> 
                        <span class="text-primary"><a href="{{ route('admin.orders.show', ['id' => $order->id]) }}"><i class="feather icon-eye"></i></a></span>
                        {{-- <span class="action-edit text-primary"><a href="{{ route('admin.orders.edit', ['id' => $order->id]) }}"><i class="feather icon-edit"></i></a></span> --}}
                        {{-- <span class="delete-row text-danger" data-url="{{ url('admin/orders/' . $order->id) }}"><i class="feather icon-trash"></i></span> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- table content --}}
    {{-- no data found div --}}
    @if ($orders->count() == 0)
        <div class="d-flex flex-column w-100 align-center mt-4">
            <img src="{{asset('admin/app-assets/images/pages/404.png')}}" alt="">
            <span class="mt-2" style="font-family: cairo">{{__('admin.there_are_no_matches_matching')}}</span>
        </div>
    @endif
    {{-- no data found div --}}

</div>
{{-- pagination  links div --}}
@if ($orders->count() > 0 && $orders instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="d-flex justify-content-center mt-3">
        {{$orders->links()}}
    </div>
@endif
{{-- pagination  links div --}}

