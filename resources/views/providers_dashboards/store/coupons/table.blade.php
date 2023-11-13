<table class="table text-center" style="width: 100%">
    <thead class="table-head">
        <tr>
            <th class="font10">@lang('site.serial_number')</th>
            <th class="font10">{{ __('store.discount code') }}</th>
            <th class="font10">{{ __('store.discount type') }}</th>
            <th class="font10">{{ __('store.discount value') }}</th>
            <th class="font10">{{ __('store.Expiry date') }}</th>
            <th class="font10">{{ __('store.Activate or deactivate the coupon') }}</th>
            <th class="font10">{{ __('store.Added date') }}</th>
            <th class="font10"></th>
        </tr>
    </thead>
    <tbody data-class-name="table-body">
        @if ($coupons->count() != 0)

            @foreach ($coupons as $key => $coupon)
                <tr>
                    <td class="font12">{{ '#' . $key + 1 }}</td>

                    <td>
                        <span class="d-flex justify-content-center align-items-center">{{ $coupon->code }}</span>
                    </td>
                    <td>
                        <span class="d-flex justify-content-center align-items-center">{{ __('store.' . $coupon->type) }}</span>
                    </td>

                    <td>
                        <span class="d-flex justify-content-center align-items-center">{{ $coupon->discount }}</span>
                    </td>

                    <td>
                        <span class="d-flex justify-content-center align-items-center">{{ Carbon\Carbon::parse($coupon->expire_date)->translatedFormat('j F Y') }}</span>
                    </td>

                    <td>
                        <span class="d-flex justify-content-center align-items-center">
                            @if($coupon->status == 'available')
                                <span class="btn btn-sm round btn-outline-danger changeStatusClosed"  data-id="{{$coupon->id}}">
                                {{__('admin.Stop_Coupon')}}  <i class="feather icon-slash"></i>
                            </span>
                            @else
                                <span class="btn btn-sm round btn-outline-success open-coupon" data-toggle="modal" data-target="#couponModal" data-id="{{$coupon->id}}">
                                {{__('admin.reactivation_Coupon')}}  <i class="feather icon-rotate-cw"></i>
                            </span>
                            @endif
                        </span>
                    </td>

                    <td class="font12">
                        <span class="d-flex justify-content-center align-items-center">{{ Carbon\Carbon::parse($coupon->created_at)->translatedFormat('j F Y') }}</span>
                    </td>
                    <td  class="drop-co"><i class="fa-solid fa-ellipsis drop-icon drop-icon" onclick="sm(this)"></i>
                        <ul class="drop-down dropDownData">
                            <li>
                                <a href="{{ route('store.coupons.edit', $coupon->id) }}" >
                                    <span class="icon-co"><i class="fa-solid fa-pen-to-square"></i></span>{{ __('store.edit') }}</a>
                            </li>
                            <li>
                                <a href="#" class="delete-row" data-val="{{ $coupon->id }}">
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
@if ($coupons->count() > 0 && $coupons instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="pag-all d-flex align-items-center justify-content-between" >
        <div class="pag-right">@lang('site.show_results_from') {{ $coupons->firstItem() }}-{{ $coupons->total() }}</div>
        <div class="pag-left">{{$coupons->links()}}</div>
    </div>
@endif

    @if ($coupons->count() == 0)
        @include('shared.empity')
    @endif