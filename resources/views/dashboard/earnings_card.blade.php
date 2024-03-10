<div class="card shadow-sm">
    <div class="card-header no-border">
        <div class="d-flex justify-content-between">
            <h3 class="card-title">{{ trans('lang.earning_plural') }}</h3>
            <a href="{{ route('booking.service.index') }}">
                {{ trans('lang.dashboard_view_all_payments') }}
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="d-flex">
            <p class="d-flex flex-column">
                @foreach ($bookings as $booking)
                    <span class="text-bold text-lg">{{ $booking->amount }}</span>
                @endforeach
                <span>{{ trans('lang.dashboard_earning_over_time') }}</span>
            </p>
            <p class="ml-auto d-flex flex-column text-right">
                <span class="text-success">{{ $bookings_amount }}</span>
                <span class="text-muted">{{ trans('lang.dashboard_total_bookings') }}</span>
            </p>
        </div>
        <!-- /.d-flex -->

        <div class="position-relative mb-4">
            {{-- <canvas id="sales-chart" height="200"></canvas> --}}
        </div>

        <div class="d-flex flex-row justify-content-end">
            <span class="mr-2"> <i class="fas fa-square text-primary"></i>
                {{ trans('lang.dashboard_this_year') }} </span>
        </div>
    </div>
</div>
