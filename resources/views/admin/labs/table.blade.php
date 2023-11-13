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
                <th>{{__('admin.identity_id')}}</th>
                @if (request()->segment(3) == 'pending')
                <th>{{ __('admin.control_request') }}</th>
                @endif
                @if (request()->segment(3) == 'all' ) 
                <th>{{ __('admin.status') }}</th>
                @endif
                <th>{{__('admin.ban_status')}}</th>
                <th>{{__('admin.branches')}}</th>
                <th>{{__('admin.control')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($labs as $lab)
                <tr class="delete_row">
                    <td class="text-center">
                        <label class="container-checkbox">
                        <input type="checkbox" class="checkSingle" id="{{ $lab->id }}">
                        <span class="checkmark"></span>
                        </label>
                    </td>
                    <td><img src="{{$lab->image}}" width="50px" height="50px" alt=""></td>
                    <td>{{ $lab->name }}</td>
                    <td>{{ $lab->email }}</td>
                    <td>{{ $lab->phone }}</td>
                    <td>{{ $lab->identity_id }}</td>
                    @if (request()->segment(3) == 'pending')
                    <td>

                        @if ($lab->is_approved == 'pending')
                            <span class="btn btn-sm btn-outline-success is_approved"
                                data-url="{{ route('admin.lab.request', ['id' => $lab->id]) }}"
                                data-name="accepted" data-id="{{ $lab->id }}">
                                {{ awtTrans('موافقة') }}
                                <i class="la la-close font-medium-2"></i>
                            </span>

                            <span class="btn btn-sm btn-outline-danger is_approved"
                                data-url="{{ route('admin.lab.request', ['id' => $lab->id]) }}"
                                data-name="rejected" data-id="{{ $lab->id }}">
                                {{ awtTrans('رفض') }}
                                <i class="la la-check font-medium-2"></i>
                            </span>
                        @endif

                    </td>

                    
                @endif

                @if (request()->segment(3) == 'all')
                <td>
                    @if ($lab->is_approved == 'accepted')
                    <span class="btn btn-sm round btn-outline-success">
                        {{ __('admin.client_accept') }} <i class="la la-close font-medium-2"></i>
                      </span>

                      @else
                      <span class="btn btn-sm round btn-outline-danger">
                        {{ __('admin.client_waiting') }} <i class="la la-close font-medium-2"></i>
                      </span>
                    @endif
                </td>
                @endif


                    <td>
                        @if ($lab->is_blocked)
                        <span class="btn btn-sm round btn-outline-danger">
                            {{ __('admin.Prohibited') }} <i class="la la-close font-medium-2"></i>
                        </span>
                        @else
                        <span class="btn btn-sm round btn-outline-success">
                            {{ __('admin.Unspoken') }} <i class="la la-check font-medium-2"></i>
                        </span>
                        @endif
                    </td>

                    <td><a href="{{route('admin.lab.branchs.all' , ['id' => $lab->id])}}">{{__('admin.view')}}</a></td>

                    
                    <td class="product-action"> 
                        <span class="text-primary"><a href="{{ route('admin.labs.show', ['id' => $lab->id]) }}"><i class="feather icon-eye"></i></a></span>
                        <span class="action-edit text-primary"><a href="{{ route('admin.labs.edit', ['id' => $lab->id]) }}"><i class="feather icon-edit"></i></a></span>
                        <span class="delete-row text-danger" data-url="{{ url('admin/labs/' . $lab->id) }}"><i class="feather icon-trash"></i></span>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- table content --}}
    {{-- no data found div --}}
    @if ($labs->count() == 0)
        <div class="d-flex flex-column w-100 align-center mt-4">
            <img src="{{asset('admin/app-assets/images/pages/404.png')}}" alt="">
            <span class="mt-2" style="font-family: cairo">{{__('admin.there_are_no_matches_matching')}}</span>
        </div>
    @endif
    {{-- no data found div --}}

</div>
{{-- pagination  links div --}}
@if ($labs->count() > 0 && $labs instanceof \Illuminate\Pagination\AbstractPaginator )
    <div class="d-flex justify-content-center mt-3">
        {{$labs->links()}}
    </div>
@endif
{{-- pagination  links div --}}

