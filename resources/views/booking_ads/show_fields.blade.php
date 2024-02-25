<div class="col-12">
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">{{ trans('lang.booking_details') }}</h5>
            <div class="row pt-5">
                <div class="col-md-6">
                    <div class="form-group">
                        <strong>{{ trans('lang.garage') }}:</strong>
                        <p>{{ $booking_ad->garage->full_name }}</p>
                    </div>

                    <div class="form-group">
                        <strong>{{ trans('lang.display_duration') }}:</strong>
                        <p>{{ $booking_ad->display_duration }}</p>
                    </div>

                    <div class="form-group">
                        <strong>{{ trans('lang.payment_amount') }}:</strong>
                        <p>{{ $booking_ad->amount }}</p>
                    </div>

                    <div class="form-group">
                        <strong>{{ trans('lang.display') }}:</strong>
                        <p>{{ $booking_ad->display ? trans('lang.yes') : trans('lang.no') }}</p>
                    </div>

                    <div class="form-group">
                        <strong>{{ trans('lang.format') }}:</strong>
                        <p>
                            @if ($booking_ad->format === 0)
                                {{ trans('lang.text') }}
                            @elseif($booking_ad->format === 1)
                                {{ trans('lang.image') }}
                            @elseif($booking_ad->format === 2)
                                {{ trans('lang.video') }}
                            @endif
                        </p>
                    </div>

                    <div class="form-group">
                        @if ($booking_ad->format === 0)
                            <strong>{{ trans('lang.text') }}:</strong>
                            <p>{{ $booking_ad->text }}</p>
                        @elseif($booking_ad->format === 1)
                            <strong>{{ trans('lang.image') }}:</strong>
                            <div>
                                <img class="rounded" style="height: 100px;" alt="{{ trans('lang.image') }}"
                                    src="{{ asset('storage/images/ads/' . $booking_ad->media()->first()?->imageName()) }}">
                            </div>
                        @endif
                    </div>

                    <div class="form-group">
                        <strong>{{ trans('lang.gender') }}:</strong>
                        <p>{{ $booking_ad->gender ? trans('lang.male') : trans('lang.female') }}</p>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <strong>{{ trans('lang.coupon') }}:</strong>
                        <p>{{ $booking_ad->coupon }}</p>
                    </div>

                    <div class="form-group">
                        <strong>{{ trans('lang.car_type') }}:</strong>
                        <p>{{ $booking_ad->car_type }}</p>
                    </div>

                    <div class="form-group">
                        <strong>{{ trans('lang.car_start_date') }}:</strong>
                        <p>{{ $booking_ad->car_start_date }}</p>
                    </div>

                    <div class="form-group">
                        <strong>{{ trans('lang.car_end_date') }}:</strong>
                        <p>{{ $booking_ad->car_end_date }}</p>
                    </div>

                    <div class="form-group">
                        <strong>{{ trans('lang.booking_status') }}:</strong>
                        <p>
                            @if ($booking_ad->status === 0)
                                <span class="badge bg-warning">{{ trans('lang.pending') }}</span>
                            @elseif($booking_ad->status === 1)
                                <span class="badge bg-success">{{ trans('lang.approved') }}</span>
                            @elseif($booking_ad->status === 2)
                                <span class="badge bg-danger">{{ trans('lang.rejected') }}</span>
                            @endif
                        </p>
                    </div>

                    <div class="form-group">
                        <strong>{{ trans('lang.rejection_reason') }}:</strong>
                        <p>{{ $booking_ad->rejection_reason }}</p>
                    </div>

                    <div class="form-group">
                        <strong>{{ trans('lang.tax_updated_at') }}:</strong>
                        <p>{{ $booking_ad->updated_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
