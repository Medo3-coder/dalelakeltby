<ul class="my-drop-now show-drop">
    @forelse($offers as $offer)
        <li>
            <a href="{{ route('lab.medicalDevices.offerDetails', $offer->id) }}" class="between-divs">
                <div class="flex-in-drop">
                    <img class="search-img-sm" src="{{ $offer->image }}" width="50px" height="50px" alt="" />
                    <div class="in-f-text">{{ \Illuminate\Support\Str::limit($offer->name, 10) }}</div>
                </div>
                <div class="num-or">{{ __('store.The number of items available') }} : <span>{{ count($offer->products) . '' }}</span></div>
            </a>
        </li>

    @empty
        <h4 class="float-search">{{ __('store.There is no search result') }}</h4>
        <img class="float-search" src="{{ asset('/') }}dashboard/imgs/empty.png" alt="">
    @endforelse

</ul>