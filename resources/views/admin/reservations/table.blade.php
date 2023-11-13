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
                <th>{{__('admin.paient_name')}}</th>
                <th>{{__('admin.age')}}</th>
                <th>{{__('admin.final_total')}}</th>
                <th>{{__('admin.control')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservations as $reservation)
                <tr class="delete_row">
                    <td class="text-center">
                        <label class="container-checkbox">
                        <input type="checkbox" class="checkSingle" id="{{ $reservation->id }}">
                        <span class="checkmark"></span>
                        </label>
                    </td>
                    @if ($reservation->reservation_for  == 'same_person')
                    <td>{{ $reservation->user->name }}</td>
                    <td>{{ $reservation->user->age }}</td>

                    @else
                    <td>{{ $reservation->paient_name }}</td>
                    <td>{{ $reservation->paient_age }}</td>
                    @endif

         
                    <td>{{ $reservation->final_total }}</td>
          
                    
                  
                        {{-- <span class="text-primary"><a href="{{ route('admin.reservations.show', ['id' => $reservation->id]) }}"><i class="feather icon-eye"></i></a></span> --}}
                        <td class="product-action">
                            <span class="text-primary"><a href="{{ route('admin.reservations.show', ['id' => $reservation->id]) }}"><i class="feather icon-eye"></i></a></span>
                    
                         </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- table content --}}
    {{-- no data found div --}}
    @if ($reservations->count() == 0)
        <div class="d-flex flex-column w-100 align-center mt-4">
            <img src="{{asset('admin/app-assets/images/pages/404.png')}}" alt="">
            <span class="mt-2" style="font-family: cairo">{{__('admin.there_are_no_matches_matching')}}</span>
        </div>
    @endif
    {{-- no data found div --}}

</div>
{{-- pagination  links div --}}
@if ($reservations->count() > 0 && $reservations instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="d-flex justify-content-center mt-3">
        {{$reservations->links()}}
    </div>
@endif
{{-- pagination  links div --}}

