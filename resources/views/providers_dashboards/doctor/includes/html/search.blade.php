<ul class="my-drop-now show-drop">
    @forelse($medicines as $medicine)
        <li>
            <a href="{{ route('doctor.medicine.edit', $medicine->id) }}" class="between-divs">
                <div class="flex-in-drop">
                    <img class="search-img-sm" src="{{ $medicine->image }}" width="50px" height="50px" alt="" />
                    <div class="in-f-text">{{ $medicine->name }}</div>
                </div>
                <div class="num-or">{{ \Illuminate\Support\Str::limit($medicine->type, 15) }}</div>
            </a>
        </li>

    @empty
        <h4 class="float-search">{{ __('store.There is no search result') }}</h4>
        <img class="float-search" src="{{ asset('/') }}dashboard/imgs/empty.png" alt="">
    @endforelse

</ul>