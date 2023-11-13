<div class="card-white spe-pad">
    <div class="row">

        @forelse ($stores as $store)
            <div class="col-lg-4 col-md-6 col-12">
                <div class="device-box text-center">
                    <img class="border-radious-spe" src="{{ $store->image }}" alt="" />
                    <div class="card_foot card-f-spe">
                        <h6 class="text-center font_bold no-border-bottom">{{ $store->name }}</h6>
                        <div class="phar-titles white-fire mb-1">
                            @lang('localize.address') : {{ $store->firstBranch()->address }}
                        </div>
                        <div class="phar-titles white-fire mb-1">
                            @lang('localize.email') : {{ $store->email }}
                        </div>
                        <div class="phar-titles white-fire mb-1">
                            @lang('localize.phone_number') : {{ $store->phone }}
                        </div>
                        <div class="flex-device justify-content-center">
                            <a href="{{ route('pharmacy.stores.details', $store->id) }}"
                                class="link-device up">@lang('localize.more')</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            @include('shared.empity')
        @endforelse

    </div>
    @if ($stores->count() > 0 && $stores instanceof \Illuminate\Pagination\AbstractPaginator)
        <div class="pag-all d-flex align-items-center justify-content-between">
            <div class="pag-right">@lang('site.show_results_from') {{ $stores->firstItem() }}-{{ $stores->total() }}
            </div>
            <div class="pag-left">{{ $stores->links() }}</div>
        </div>
    @endif
</div>
