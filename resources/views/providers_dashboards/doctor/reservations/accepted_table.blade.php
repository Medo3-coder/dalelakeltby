<table class="table text-center" style="width: 100%">
    <thead class="table-head">
        <tr>
            <th class="font10">@lang('site.serial_number')</th>
            <th class="font10">@lang('doctor.reservation_num')</th>
            <th class="font10">@lang('site.paient_name')</th>
            <th class="font10">@lang('doctor.patient_address')</th>
            <th class="font10">@lang('site.reservation_date')</th>
            <th class="font10"></th>
            <th class="font10"></th>
            <th class="font10"></th>
        </tr>
    </thead>
    <tbody data-class-name="table-body">
        @if ($reservations->count() != 0)
            @foreach ($reservations as $key => $reservation)
                <tr>
                    <td class="font12">{{ ++$key }}</td>

                    <td class="font12">#{{ $reservation->id }}</td>

                    <td class="font12">
                        <span
                            class="fontBold">{{ $reservation->name }}</span>
                    </td>

                    <td class="font12">
                        <span class="text-secondary">{{ $reservation->user->map_desc }}</span>
                    </td>

                    <td class="font12">
                        <span
                            class="d-flex justify-content-center align-items-center">{{ $reservation->date->format('d-m-Y ') . date(' H:i A', strtotime($reservation->time)) }}</span>
                    </td>

                    <td class="font12">
                        <a class="d-flex justify-content-center align-items-center"
                            href="{{ route('doctor.reservations.details', $reservation->id) }}">@lang('site.reservation_details')</a>
                    </td>

                    <td class="font12">
                        <button type="button"
                            @if (!in_array($reservation->status, ['lab_send_results', 'approved'])) disabled 
                            @else
                            data-url="{{ route('doctor.reservations.patientEnter', $reservation->id) }}" @endif
                            class="table-btn-spe main-bg up accept-patient @if (!in_array($reservation->status, ['lab_send_results', 'approved'])) accept-patient follow followed followed2 @else follow unfollowed @endif  ">
                            @if (in_array($reservation->status, ['lab_send_results', 'approved']))
                                @lang('doctor.patient_enter')
                            @else
                                @lang('doctor.patient_entered')
                            @endif
                        </button>
                    </td>

                    <td class="font12">
                        @switch($reservation->status)
                            @case('transfer_to_lab')
                                @lang('doctor.reservation_status.transfer_to_lab')
                            @break

                            @case('lab_send_results')
                                @lang('doctor.reservation_status.lab_send_results')
                            @break

                            @case('on_progress')
                                @lang('doctor.reservation_status.on_progress')
                            @break

                            @default
                                ------------
                        @endswitch
                    </td>


                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if ($reservations->count() > 0 && $reservations instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="pag-all d-flex align-items-center justify-content-between">
        <div class="pag-right">@lang('site.show_results_from') {{ $reservations->firstItem() }}-{{ $reservations->total() }}</div>
        <div class="pag-left">{{ $reservations->links() }}</div>
    </div>
@endif

@if ($reservations->count() == 0)
    <div class="no-data d-flex justify-content-center">
        <img src="{{ asset('/') }}dashboard/imgs/empty.png" alt="">
    </div>
@endif
