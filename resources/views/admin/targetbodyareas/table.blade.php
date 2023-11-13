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
                <th>{{__('admin.name')}}</th>
                <th>{{__('admin.control')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($targetbodyareas as $targetbodyarea)
                <tr class="delete_row">
                    <td class="text-center">
                        <label class="container-checkbox">
                        <input type="checkbox" class="checkSingle" id="{{ $targetbodyarea->id }}">
                        <span class="checkmark"></span>
                        </label>
                    </td>
                    <td>{{ $targetbodyarea->name }}</td>
              
                    <td class="product-action"> 
                        <span class="text-primary"><a href="{{ route('admin.targetbodyareas.show', ['id' => $targetbodyarea->id]) }}"><i class="feather icon-eye"></i></a></span>
                        <span class="action-edit text-primary"><a href="{{ route('admin.targetbodyareas.edit', ['id' => $targetbodyarea->id]) }}"><i class="feather icon-edit"></i></a></span>
                        <span class="delete-row text-danger" data-url="{{ url('admin/targetbodyareas/' . $targetbodyarea->id) }}"><i class="feather icon-trash"></i></span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- table content --}}
    {{-- no data found div --}}
    @if ($targetbodyareas->count() == 0)
        <div class="d-flex flex-column w-100 align-center mt-4">
            <img src="{{asset('admin/app-assets/images/pages/404.png')}}" alt="">
            <span class="mt-2" style="font-family: cairo">{{__('admin.there_are_no_matches_matching')}}</span>
        </div>
    @endif
    {{-- no data found div --}}

</div>
{{-- pagination  links div --}}
@if ($targetbodyareas->count() > 0 && $targetbodyareas instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="d-flex justify-content-center mt-3">
        {{$targetbodyareas->links()}}
    </div>
@endif
{{-- pagination  links div --}}

