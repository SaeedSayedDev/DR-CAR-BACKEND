<!-- Modal -->
<div class="modal fade" id="bookingAdDetailsModal{{ $booking_ad->id }}" tabindex="-1" role="dialog"
    aria-labelledby="bookingAdDetailsModalLabel{{ $booking_ad->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingAdDetailsModalLabel{{ $booking_ad->id }}">
                    {{ trans('lang.booking_ads_details') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <img class="rounded image-modal" alt="{{ trans('lang.category_image') }}"
                            src="{{ $booking_ad->media[0]->image ?? $noneImage }}">
                    </div>
                    <div class="col-md-7">
                        <p>
                            <strong>{{ trans('lang.text') }}:</strong>
                            {{ $booking_ad->text }}
                        </p>
                        <p>
                            <strong>{{ trans('lang.gender') }}:</strong>
                            {{ $booking_ad->gender ? trans('lang.male') : trans('lang.female') }}
                        </p>
                        <p>
                            <strong>{{ trans('lang.coupon') }}:</strong>
                            {{ $booking_ad->coupon }}
                        </p>
                        <p>
                            <strong>{{ trans('lang.car_type') }}:</strong>
                            {{ $booking_ad->car_type }}
                        </p>
                        <p>
                            <strong>{{ trans('lang.car_start_date') }}:</strong>
                            {{ $booking_ad->car_start_date }}
                        </p>
                        <p>
                            <strong>{{ trans('lang.car_end_date') }}:</strong>
                            {{ $booking_ad->car_end_date }}
                        </p>
                        <p>
                            <strong>{{ trans('lang.rejection_reason') }}:</strong>
                            {{ $booking_ad->rejection_reason }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    {{ trans('lang.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
