<nav class="navbar-me" id="navbar">
    <div class="container">
        <div class="content">

            <div class="menu" id="menu">
                <img src="{{ asset('dashboard/imgs/noun_List_2946302.png') }}" alt="" />
            </div>

            <form action="{{ url(request()->segment(1) . '/search') }}" method="POST" enctype="multipart/form-data"
                class="search">
                @csrf
                <div class="form__label overflowx-v flex-profile-d">
                    <input type="text" name="search"
                        placeholder="@if (request()->segment(1) == 'store') {{ __('store.Please enter product search terms') }}@elseif(request()->segment(1) == 'doctor'){{ __('store.Please enter the search words for the drug') }}@else {{ __('translation.search_offer') }} @endif"
                        class="placeholder-spe" />
                    <button type="submit" class="fl-bt search-submit"> <i class="fa-solid fa-magnifying-glass"></i>
                    </button>
                    <div class="upload-search">

                    </div>
                </div>
                <div class="error_show error_search"> </div>

            </form>


            <div class="left">
                @if (in_array(request()->segment(1), ['lab', 'pharmacy']))
                    <div class="not">
                        <a href="{{ route(request()->segment(1) . '.cart.index') }}"></a>
                        <img src="{{ asset('dashboard/imgs/Group 83243.png') }}" />
                        <span class="number"
                            id="nav_cart_counter">{{ provider(request()->segment(1))->carts->count() }}</span>
                    </div>
                @endif
                <div class="not">
                    <a href="{{ url(request()->segment(1) . '/notifications') }}"></a>
                    <img src="{{ asset('dashboard/imgs/bell.png') }}" />
                    <span
                        class="number">{{ Auth::guard(request()->segment(1))->user()->unreadNotifications()->count() }}</span>
                </div>

                @if (authUser(request()->segment(1))->parent_id == null)
                    <a href="{{ route(request()->segment(1) . '.profile') }}">
                        <div class="account">
                            <img src="{{ authUser(request()->segment(1))->image }}" alt="" />
                            <div class="info">
                                <h3>{{ authUser(request()->segment(1))->name }}</h3>
                                <span>{{ __('store.General Director') }}</span>
                            </div>
                        </div>
                    </a>
                @endif

            </div>
        </div>
    </div>
</nav>
