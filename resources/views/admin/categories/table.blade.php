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
                @if ($id == null)
                    <th>{{ __ ('admin.view_sub_sections')}}</th>
                @endif
                <th>{{__('admin.control')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
                <tr class="delete_row">
                    <td class="text-center">
                        <label class="container-checkbox">
                            <input type="checkbox" class="checkSingle" id="{{$category->id}}">
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td><img src="{{$category->image}}" width="50px" height="50px" alt=""></td>
                    <td>{{$category->name}}</td>
                    @if ($id == null)
                        <td><a href="{{route('admin.categories.index' , ['id' => $category->id])}}">{{__('admin.view')}}</a></td>
                    @endif
                    <td class="product-action">
                        <span class="text-primary"><a href="{{route('admin.categories.show' , ['id' => $category->id])}}"><i class="feather icon-eye"></i></a></span>
                        <span class="action-edit text-primary"><a href="{{route('admin.categories.edit' , ['id' => $category->id])}}"><i class="feather icon-edit"></i></a></span>
                        <span class="text-danger delete-row" data-url="{{url('admin/categories/'.$category->id)}}"><i class="feather icon-trash"></i></span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- table content --}}
    {{-- no data found div --}}
    @if ($categories->count() == 0)
        <div class="d-flex flex-column w-100 align-center mt-4">
            <img src="{{asset('admin/app-assets/images/pages/404.png')}}" alt="">
            <span class="mt-2" style="font-family: cairo">{{__('admin.there_are_no_matches_matching')}}</span>
        </div>
    @endif
    {{-- no data found div --}}

</div>
{{-- pagination  links div --}}
@if ($categories->count() > 0 && $categories instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="d-flex justify-content-center mt-3">
        {{$categories->links()}}
    </div>
@endif
{{-- pagination  links div --}}