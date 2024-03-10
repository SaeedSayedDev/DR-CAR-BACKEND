<div class="col-lg-3 col-6">
    <div class="small-box bg-white shadow-sm">
        <div class="inner">
            <h3 class="text-primary">{{ $bookings_count }}</h3>
            <p>{{ trans('lang.dashboard_total_bookings') }}</p>
        </div>
        <div class="icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <a href="{{ route('booking.service.index') }}"
            class="small-box-footer">{{ trans('lang.dashboard_more_info') }}
            <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-3 col-6">
    <div class="small-box bg-white shadow-sm">
        <div class="inner">
            <h3 class="text-primary">{{ $bookings_amount }} {{ trans('lang.dirham')}}</h3>

            <p>
                {{ trans('lang.dashboard_total_earnings') }}
                <span style="font-size: 11px">({{ trans('lang.dashboard_after taxes') }})</span>
            </p>
        </div>
        <div class="icon">
            <i class="fas fa-hand-holding-usd"></i>
        </div>
        <a href="{{ route('booking.service.index') }}"
            class="small-box-footer">{{ trans('lang.dashboard_more_info') }}
            <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-3 col-6">
    <div class="small-box bg-white shadow-sm">
        <div class="inner">
            <h3 class="text-primary">{{ $providers_count }}</h3>
            <p>{{ trans('lang.e_provider_plural') }}</p>
        </div>
        <div class="icon">
            <i class="fas fa-users-cog"></i>
        </div>
        <a href="{{ route('eProviders.index') }}"
            class="small-box-footer">{{ trans('lang.dashboard_more_info') }}
            <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>

<div class="col-lg-3 col-6">
    <div class="small-box bg-white shadow-sm">
        <div class="inner">
            <h3 class="text-primary">{{ $customers_count }}</h3>
            <p>{{ trans('lang.dashboard_total_customers') }}</p>
        </div>
        <div class="icon">
            <i class="fas fa-users"></i>
        </div>
        <a href="{!! route('users.index', ['filters[]' => 'customer']) !!}" class="small-box-footer">{{ trans('lang.dashboard_more_info') }}
            <i class="fas fa-arrow-circle-right"></i>
        </a>
    </div>
</div>