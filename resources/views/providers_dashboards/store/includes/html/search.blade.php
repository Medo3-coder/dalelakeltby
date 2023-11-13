<ul class="my-drop-now show-drop">
    @forelse($products as $product)
        <li>
            <a href="{{ route('store.products.show', $product->id) }}" class="between-divs">
                <div class="flex-in-drop">
                    <img class="search-img-sm" src="{{ $product->image }}" width="50px" height="50px" alt="" />
                    <div class="in-f-text">{{ $product->name }}</div>
                </div>
                <div class="num-or">#{{ $product->product_num }}</div>
            </a>
        </li>
    @empty
        <h4 class="float-search">{{ __('store.There is no search result') }}</h4>
        <img class="float-search" src="{{ asset('/') }}dashboard/imgs/empty.png" alt="">
    @endforelse

</ul>