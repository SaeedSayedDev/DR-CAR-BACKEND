<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ trans('lang.info_basic') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <strong>{{ trans('lang.user_name') }}:</strong>
                </div>
                <div class="col-sm-6">
                    {{ $user->full_name }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <strong>{{ trans('lang.email') }}:</strong>
                </div>
                <div class="col-sm-6">
                    {{ $user->email }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <strong>{{ trans('lang.role') }}:</strong>
                </div>
                <div class="col-sm-6">
                    <span class="badge bg-primary">
                        @if ($user->role_id == 2)
                            {{ trans('lang.customer') }}
                        @elseif ($user->role_id == 3)
                            {{ trans('lang.winch') }}
                        @elseif ($user->role_id == 4)
                            {{ trans('lang.garage') }}
                        @endif
                    </span>
                </div>
            </div>
            @if ($user->user_information)
                <div class="row">
                    <div class="col-sm-6">
                        <strong>{{ trans('lang.gender') }}:</strong>
                    </div>
                    <div class="col-sm-6">
                        {{ $user->user_information->gender ? trans('lang.male') : trans('lang.female') }}
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<div class="col-md-6">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ trans('lang.info_more') }}</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-sm-6">
                    <strong>{{ trans('lang.user_phone_number') }}:</strong>
                </div>
                <div class="col-sm-6">
                    {{ $user->info->phone_number }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <strong>{{ trans('lang.address') }}:</strong>
                </div>
                <div class="col-sm-6">
                    {{ $user->info->address }}
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <strong>{{ trans('lang.bio') }}:</strong>
                </div>
                <div class="col-sm-6">
                    {{ $user->info->short_biography }}
                </div>
            </div>
            @if ($user->user_information)
                <div class="row">
                    <div class="col-sm-6">
                        <strong>{{ trans('lang.car') }}:</strong>
                    </div>
                    <div class="col-sm-6">
                        <a href="{{ route('cars.car', $user->user_information->car_id) }}">
                            {{ $user->user_information->car->name }}
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@if ($user->carLicense)
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('lang.car_license') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{ route('carLicenses.user', $user->id) }}" class="btn btn-primary">
                            {{ trans('lang.car_license_details') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if ($user->wallet)
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{ trans('lang.wallet') }}</h3>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{ route('wallets.wallet', $user->wallet->id) }}" class="btn btn-primary">
                            {{ trans('lang.wallet_details') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if ($user->garage_data)
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title">{{ trans('lang.e_service_plural') }}</h3>
                <span class="ml-auto">{{ trans('lang.total') }}: {{ $user->garage_data->services_count }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{ route('eServices.user', $user->id) }}" class="btn btn-primary">
                            {{ trans('lang.e_service_details') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if ($user->bookingAds->isNotEmpty())
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title">{{ trans('lang.booking_ad_plural') }}</h3>
                <span class="ml-auto">{{ trans('lang.total') }}: {{ $user->bookingAds_count }}</span>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{ route('booking.ads.user', $user->id) }}" class="btn btn-primary">
                            {{ trans('lang.booking_ads_details') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif

@if ($user->carReports->isNotEmpty())
    <div class="col-md-6">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <h3 class="card-title">{{ trans('lang.car_report_plural') }}</h3>
                <span class="ml-auto">{{ trans('lang.total') }}: {{ $user->carReports_count }}</span>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a href="{{ route('carReports.user', $user->id) }}" class="btn btn-primary">
                            {{ trans('lang.car_report_details') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
