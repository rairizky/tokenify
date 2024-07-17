<div class="side-nav">
    <div class="side-nav-inner">
        <ul class="side-nav-menu scrollable">
            {{-- admin --}}
            @if (Auth::user()->level->name === "admin")
                {{-- customer --}}
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="anticon anticon-user"></i>
                        </span>
                        <span class="title">Customer</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('dashboard.customer.data.index') }}">Data</a>
                        </li>
                    </ul>
                </li>

                {{-- product --}}
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="anticon anticon-appstore"></i>
                        </span>
                        <span class="title">Product</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('dashboard.product.data.index') }}">Data</a>
                        </li>
                    </ul>
                </li>

                {{-- transaction --}}
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="anticon anticon-tags"></i>
                        </span>
                        <span class="title">Transaction</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('dashboard.transaction.index') }}">Data</a>
                        </li>
                    </ul>
                </li>
            @endif


            {{-- user --}}
            @if (Auth::user()->level->name === "user")
                <li class="nav-item dropdown">
                    <a class="dropdown-toggle" href="javascript:void(0);">
                        <span class="icon-holder">
                            <i class="anticon anticon-dollar"></i>
                        </span>
                        <span class="title">Transaction</span>
                        <span class="arrow">
                            <i class="arrow-icon"></i>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('dashboard.transaction.make.index') }}">Make Transaction</a>
                        </li>
                        <li>
                            <a href="{{ route('dashboard.transaction.history.index') }}">History</a>
                        </li>
                    </ul>
                </li>
            @endif
        </ul>
    </div>
</div>
