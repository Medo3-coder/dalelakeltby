<div class="position-relative">
    {{-- table loader  --}}
    <div class="table_loader">
        {{ __('admin.loading') }}
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
                <th>{{ __('admin.image') }}</th>
                <th>{{__('admin.address')}}</th>
                <th>{{__('admin.comerical_record')}}</th>
                <th>{{__('admin.control')}}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($lab_branches as $branch)
                <tr class="delete_row">
                    <td class="text-center">
                        <label class="container-checkbox">
                            <input type="checkbox" class="checkSingle" id="{{ $branch->id }}">
                            <span class="checkmark"></span>
                        </label>
                    </td>
                    <td><img src="{{ $branch->OpeningCertificateImage }}" width="50px" height="50px" alt=""></td>
                    <td>{{ $branch->address }}</td>
                    <td>{{ $branch->comerical_record }}</td>
                

               <td>
                <span class="text-primary"><a href="{{ route('admin.lab.Branch.show', ['id' => $branch->id]) }}"><i class="feather icon-eye"></i></a></span>
                <span class="action-edit text-primary"><a href="{{ route('admin.lab.Branch.edit', ['id' => $branch->id]) }}"><i class="feather icon-edit"></i></a></span>
                <span class="delete-row text-danger" data-url="{{ url('admin/lab/branches/' . $branch->id) }}"><i class="feather icon-trash"></i></span>
               </td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- table content --}}
    {{-- no data found div --}}
    @if ($lab_branches->count() == 0)
        <div class="d-flex flex-column w-100 align-center mt-4">
            <img src="{{ asset('admin/app-assets/images/pages/404.png') }}" alt="">
            <span class="mt-2" style="font-family: cairo">{{ __('admin.there_are_no_matches_matching') }}</span>
        </div>
    @endif
    {{-- no data found div --}}

</div>
{{-- pagination  links div --}}
@if ($lab_branches->count() > 0 && $lab_branches instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="d-flex justify-content-center mt-3">
        {{ $lab_branches->links() }}
    </div>
@endif
{{-- pagination  links div --}}
