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
                <th>{{__('admin.image')}}</th>
                <th>{{__('admin.name')}}</th>
                <th>{{__('admin.email')}}</th>
                <th>{{__('admin.phone')}}</th>
                <th>{{__('doctor.time')}}</th>
                <th>{{__('admin.control')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reportrates as $reportrate)
                <tr class="delete_row">
                    <td class="text-center">
                        <label class="container-checkbox">
                        <input type="checkbox" class="checkSingle" id="{{ $reportrate->id }}">
                        <span class="checkmark"></span>
                        </label>
                    </td>
                    <td><img src="{{$reportrate->reportable->image}}" width="50px" height="50px" alt=""></td>
                    <td>{{ $reportrate->reportable->name }}</td>
                    <td>{{ $reportrate->reportable->email }}</td>
                    <td>{{ $reportrate->reportable->phone }}</td>
                    <td>{{ \Carbon\Carbon::parse($reportrate->created_at)->isoFormat('MMMM D YYYY h:m a') }}</td>

                    
                    <td class="product-action"> 
                        <span class="text-primary"><a href="{{ route('admin.reportrates.show', ['id' => $reportrate->id]) }}"><i class="feather icon-eye"></i></a></span>
                        {{--  <span class="action-edit text-primary"><a href="{{ route('admin.reportrates.edit', ['id' => $reportrate->id]) }}"><i class="feather icon-edit"></i></a></span>
                        <span class="delete-row text-danger" data-url="{{ url('admin/reportrates/' . $reportrate->id) }}"><i class="feather icon-trash"></i></span>  --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- table content --}}
    {{-- no data found div --}}
    @if ($reportrates->count() == 0)
        <div class="d-flex flex-column w-100 align-center mt-4">
            <img src="{{asset('admin/app-assets/images/pages/404.png')}}" alt="">
            <span class="mt-2" style="font-family: cairo">{{__('admin.there_are_no_matches_matching')}}</span>
        </div>
    @endif
    {{-- no data found div --}}

</div>
{{-- pagination  links div --}}
@if ($reportrates->count() > 0 && $reportrates instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="d-flex justify-content-center mt-3">
        {{$reportrates->links()}}
    </div>
@endif
{{-- pagination  links div --}}

