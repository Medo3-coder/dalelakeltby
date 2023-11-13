<table class="table text-center" style="width: 100%">
    <thead class="table-head">
        <tr>
            <th class="font10">@lang('site.serial_number')</th>
            <th class="font10">@lang('site.order_num')</th>
            <th class="font10">@lang('site.paient_name')</th>
            <th class="font10">@lang('site.category')</th>
            <th class="font10">@lang('site.sender_doctor')</th>
            <th class="font10">@lang('site.reservation_date')</th>
            <th class="font10"></th>
            <th class="font10"></th>
        </tr>
    </thead>
    <tbody data-class-name="table-body">
        @if ($reservations->count() != 0)
            @foreach ($reservations as $key => $reservation)
                <tr>
                    <td class="font12">{{ $key }}</td>

                    <td class="font12">#{{ $reservation->id }}</td>

                    <td class="font12">
                        <span
                            class="fontBold">{{ $reservation->reservation_for == 'same_person' ? $reservation->user->name : $reservation->paient_name }}</span>
                    </td>

                    <td class="font12">
                        <span class="text-secondary">{{ $reservation->labCategory->name }}</span>
                    </td>
                    
                    <td class="font12">
                        <span class="text-secondary">{{ $reservation->doctor_id ? $reservation->doctor->name : '--' }}</span>
                    </td>


                    <td class="font12">
                        <span class="d-flex justify-content-center align-items-center">{{ $reservation->date->format('d-m-Y ') . date(' H:i A', strtotime($reservation->time)) }}</span>
                    </td>

                    <td class="font12">
                        <button type="button" class="table-btn-spe main-bg up accept-patient follow unfollowed">
                            دخول المريض
                        </button>
                    </td>
                        
                    <td class="font12">
                        <a class="d-flex justify-content-center align-items-center" href="{{url('lab/reservation-details/'.$reservation->id)}}" >@lang('site.reservation_details')</a>
                    </td>



                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if ($reservations->count() > 0 && $reservations instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="pag-all d-flex align-items-center justify-content-between" >
        <div class="pag-right">@lang('site.show_results_from') {{ $reservations->firstItem() }}-{{ $reservations->total() }}</div>
        <div class="pag-left">{{$reservations->links()}}</div>
    </div>
@endif

    @if ($reservations->count() == 0)
    <div class="no-data d-flex justify-content-center">
        <img src="{{asset('storage/images/no_data.png')}}" alt="">
    </div>
@endif