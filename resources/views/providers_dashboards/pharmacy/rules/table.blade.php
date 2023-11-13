<table class="table text-center" style="width: 100%">
    <thead class="table-head">
        <tr>
            <th class="font10">@lang('site.serial_number')</th>
            <th class="font10">@lang('doctor.user_num')</th>
            <th class="font10">@lang('site.name')</th>
            <th class="font10">@lang('doctor.his_permissions')</th>
            <th class="font10"></th>
            <th class="font10"></th>
        </tr>
    </thead>
    <tbody data-class-name="table-body">
        @if ($rules->count() != 0)
            @foreach ($rules as $key => $rule)
                <tr>
                    <td class="font12">{{ ++$key }}</td>

                    <td class="font12">#{{ $rule->id }}</td>

                    <td class="font12">
                        <span class="fontBold">{{ $rule->name }}</span>
                    </td>

                    <td class="font12">
                        <span class="text-secondary">( {{$rule->role_name}} )</span>
                    </td>


                    <td class="font12">
                    <td class="drop-co"><i class="fa-solid fa-ellipsis drop-icon drop-icon" onclick="sm(this)"></i>
                        <ul class="drop-down dropDownData">

                            <li>
                                <a class="delete_account" data-url="{{route('pharmacy.rules.delete' ,$rule->id)}}" class="danger-h">
                                    <span class="icon-co">
                                        <i class="fa-solid fa-trash"></i>
                                    </span>
                                    @lang('doctor.delete_account')
                                </a>
                            </li>
                            <li>
                                <a class="change_password" data-id="{{$rule->id}}" >
                                    <span class="icon-co"><i class="fa-solid fa-pen-to-square"></i></span>@lang('admin.change_password')</a>
                            </li>
                        </ul>
                    </td>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@if ($rules->count() > 0 && $rules instanceof \Illuminate\Pagination\AbstractPaginator)
    <div class="pag-all d-flex align-items-center justify-content-between">
        <div class="pag-right">@lang('site.show_results_from') {{ $rules->firstItem() }}-{{ $rules->total() }}</div>
        <div class="pag-left">{{ $rules->links() }}</div>
    </div>
@endif

@if ($rules->count() == 0)
    <div class="no-data d-flex justify-content-center">
        <img src="{{ asset('storage/images/no_data.png') }}" alt="">
    </div>
@endif

