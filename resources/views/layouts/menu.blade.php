<li class="nav-item">
    <a class="nav-link {{ Request::is('*dashboard*') ? 'active' : '' }}" href="{!! url('dashboard') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-tachometer-alt"></i>
        @endif
        <p>{{ trans('lang.dashboard') }}</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*notifications*') ? 'active' : '' }}" href="{!! route('notifications.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-bell"></i>
        @endif
        <p>{{ trans('lang.notification_plural') }}</p>
    </a>
</li>

<li class="nav-header">{{ trans('lang.app_management') }}</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*categories*') ? 'active' : '' }}" href="{!! route('categories.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-folder-open"></i>
        @endif
        <p>{{ trans('lang.category_plural') }}</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*items*') ? 'active' : '' }}" href="{!! route('items.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-folder-open"></i>
        @endif
        <p>{{ trans('lang.item_plural') }}</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*eServices*') ? 'active' : '' }}" href="{!! route('eServices.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-pencil-ruler"></i>
        @endif
        <p>{{ trans('lang.e_service_plural') }}</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*eProviders*') ? 'active' : '' }}" href="{!! route('eProviders.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-list-alt"></i>
        @endif
        <p>{{ trans('lang.e_provider_plural') }}</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*address*') ? 'active' : '' }}" href="{!! route('addresses.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-map-marked-alt"></i>
        @endif
        <p>{{ trans('lang.address_plural') }}</p>
    </a>
</li>

<li class="nav-header">{{ trans('lang.payment_plural') }}</li>

<li class="nav-item has-treeview {{ Request::is('*booking*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('*booking*') ? 'active' : '' }}">
        @if ($icons)
            <i class="nav-icon fas fa-calendar-check"></i>
        @endif
        <p>
            {{ trans('lang.booking_plural') }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('*booking/service*') ? 'active' : '' }}"
                href="{!! route('booking.service.index') !!}">
                @if ($icons)
                    <i class="nav-icon fas fa-calendar-check"></i>
                @endif
                <p>{{ trans('lang.booking_service') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('*booking/winch*') ? 'active' : '' }}"
                href="{!! route('booking.winch.index') !!}">
                @if ($icons)
                    <i class="nav-icon fas fa-calendar-check"></i>
                @endif
                <p>{{ trans('lang.booking_winch') }}</p>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ Request::is('*booking/ads*') ? 'active' : '' }}" href="{!! route('booking.ads.index') !!}">
                @if ($icons)
                    <i class="nav-icon fas fa-ad"></i>
                @endif
                <p>{{ trans('lang.booking_ad_plural') }}</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-item has-treeview {{ Request::is('*wallet*') || Request::is('*withdraw*') ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ Request::is('*wallet*') || Request::is('*withdraw*') ? 'active' : '' }}">
        @if ($icons)
            <i class="nav-icon fas fa-wallet"></i>
        @endif
        <p>{{ trans('lang.wallet_plural') }}<i class="right fas fa-angle-left"></i></p>
    </a>

    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a class="nav-link {{ Request::is('*wallets*') ? 'active' : '' }}" href="{!! route('wallets') !!}">
                @if ($icons)
                    <i class="nav-icon fa fa-wallet"></i>
                @endif
                <p>{{ trans('lang.wallet_table') }}</p>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Request::is('*walletTransactions*') ? 'active' : '' }}"
                href="{!! route('walletTransactions') !!}">
                @if ($icons)
                    <i class="nav-icon fa fa-list-alt"></i>
                @endif
                <p>{{ trans('lang.wallet_transaction_plural') }}</p>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link {{ Request::is('*withdraws*') ? 'active' : '' }}" href="{!! route('withdraws.index') !!}">
                @if ($icons)
                    <i class="nav-icon fa fa-wallet"></i>
                @endif
                <p>{{ trans('lang.withdraw') }}</p>
            </a>
        </li>
    </ul>
</li>

<li class="nav-header">{{ trans('lang.car_plural') }}</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*cars*') ? 'active' : '' }}" href="{!! route('cars.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-car"></i>
        @endif
        <p>{{ trans('lang.car_plural') }}</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*carLicenses*') ? 'active' : '' }}" href="{!! route('carLicenses.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-id-card"></i>
        @endif
        <p>{{ trans('lang.car_license_plural') }}</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*carReports*') ? 'active' : '' }}" href="{!! route('carReports.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-file-alt"></i>
        @endif
        <p>{{ trans('lang.car_report_plural') }}</p>
    </a>
</li>

<li class="nav-header">{{ trans('lang.app_setting') }}</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*users*') ? 'active' : '' }}" href="{!! route('users.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-users"></i>
        @endif
        <p>{{ trans('lang.user_plural') }}</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*coupons*') ? 'active' : '' }}" href="{!! route('coupons.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-ticket-alt"></i>
        @endif
        <p>{{ trans('lang.coupon_plural') }}</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*taxes*') ? 'active' : '' }}" href="{!! route('taxes.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-coins"></i>
        @endif
        <p>{{ trans('lang.tax_plural') }}</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*commissions*') ? 'active' : '' }}" href="{!! route('commissions.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-coins"></i>
        @endif
        <p>{{ trans('lang.commission_plural') }}</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*prices*') ? 'active' : '' }}" href="{!! route('prices.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-dollar-sign"></i>
        @endif
        <p>{{ trans('lang.price_plural') }}</p>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link {{ Request::is('*images*') ? 'active' : '' }}" href="{!! route('images.index') !!}">
        @if ($icons)
            <i class="nav-icon fas fa-images"></i>
        @endif
        <p>{{ trans('lang.image_plural') }}</p>
    </a>
</li>
