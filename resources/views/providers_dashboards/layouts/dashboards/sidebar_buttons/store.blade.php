<li class="spe-col-act">
    <a href="{{ route('store.categories') }}" class="spe-link-spe">
              <span class="icon-co">
                <img src="{{ asset('/') }}dashboard/imgs/Group 81356.png" alt="" />
              </span>
        {{ __('store.Products categories') }}
        <i class="fa fa-list-left fa-angle-left icon-right"></i>
    </a>
</li>

<li class="spe-col-act">
    <a href="{{ route('store.coupons') }}" class="spe-link-spe">
              <span class="icon-co">
                <img src="{{ asset('/') }}dashboard/imgs/Group 81356.png" alt="" />
              </span>
        {{ __('store.discount coupons') }}
        <i class="fa fa-list-left fa-angle-left icon-right"></i>
    </a>
</li>

<li class="spe-col-act">
    <a href="{{ route('store.products') }}" class="spe-link-spe">
              <span class="icon-co">
                <img src="{{ asset('/') }}dashboard/imgs/Group 83199.png" alt="" />
              </span>
        {{ __('store.drug store') }}
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
</li>


<li class="spe-col-act">
    <a href="{{ route('store.offers') }}" class="spe-link-spe">
              <span class="icon-co">
                <img src="{{ asset('/') }}dashboard/imgs/Group 83199.png" alt="" />
              </span>
        {{ __('store.Offers submitted') }}
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
</li>
<li class="spe-col-act">
    <a href="#" class="collapse-co spe-link-spe">
              <span class="icon-co">
                <img src="{{ asset('/') }}dashboard/imgs/Group 81356.png" alt="" />
              </span>
        {{ __('store.received requests') }}
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
    <ul class="collapse-me">
        <li class="coll col-spe">
            <img src="{{ asset('/') }}dashboard/imgs/Group 8333dddfffffffff3.png" alt="" />
            <a href="{{ route('store.orders.pending') }}"
            > {{ __('store.Requests pending approval') }}
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('/') }}dashboard/imgs/Group 82936.png" alt="" />
            <a href="{{ route('store.orders.accepted') }}">
                {{ __('store.In progress requests') }}
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('/') }}dashboard/imgs/noun_Box_3093107.png" alt="" />
            <a href="{{ route('store.orders.prepared') }}">
                {{ __('store.Processed requests') }}
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('/') }}dashboard/imgs/Page-1dd.png" alt="" />
            <a href="{{ route('store.orders.rejected') }}">
                {{ __('store.Rejected requests') }}
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
    </ul>
</li>
<li class="spe-col-act">
    <a href="{{ route('store.rules.index') }}" class="collapse-co spe-link-spe">
              <span class="icon-co">
                <img src="{{ asset('/') }}dashboard/imgs/Path 48154.png" alt="" />
              </span>
        {{ __('store.Add permissions') }}
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
    <ul class="collapse-me">
        <li class="coll col-spe">
            <img src="{{ asset('/') }}dashboard/imgs/noun_Box_3093107.png" alt="" />
            <a href="{{ route('store.rules.add') }}">
                {{ __('store.Add permissions') }}
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('/') }}dashboard/imgs/Group 81387.png" alt="" />
            <a href="{{ route('store.rules.index') }}">
                {{ __('store.Added accounts') }}
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
    </ul>
</li>
<li class="spe-col-act">
    <a href="#" class="collapse-co spe-link-spe">
              <span class="icon-co">
                <img src="{{ asset('/') }}dashboard/imgs/Group 81356.png" alt="" />
              </span>
        {{ __('store.reports') }}
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
    <ul class="collapse-me">
        <li class="coll col-spe">
            <img src="{{ asset('/') }}dashboard/imgs/noun_Box_3093107.png" alt="" />
            <a href="{{ route('store.reports.beingPaid') }}">
                {{ __('store.Payment requests') }}
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('/') }}dashboard/imgs/Page-1dd.png" alt="" />
            <a href="{{ route('store.reports.paid') }}">
                {{ __('store.Paid requests') }}
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
        <li class="coll col-spe">
            <img src="{{ asset('/') }}dashboard/imgs/Page-1dd.png" alt="" />
            <a href="{{ route('store.reports.income') }}">
                {{ __('store.income') }}
                <i class="fa-solid fa-angle-left icon-right"></i>
            </a>
        </li>
    </ul>
</li>
<li class="spe-col-act">
    <a href="{{ route('store.suggestions.index') }}" class="spe-link-spe">
              <span class="icon-co">
                <img src="{{ asset('/') }}dashboard/imgs/Group 81371.png" alt="" />
              </span>
        {{ __('store.proposals') }}
        <i class="fa-solid fa-angle-left icon-right"></i>
    </a>
</li>

