<!-- Modal -->
<div class="modal fade" id="bookingDetailsModal{{ $booking_service->id }}" tabindex="-1" role="dialog"
    aria-labelledby="bookingDetailsModalLabel{{ $booking_service->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingDetailsModalLabel{{ $booking_service->id }}">
                    {{ trans('lang.booking_e_service_details') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <p>
                            <strong>{{ trans('lang.tax') }}:</strong>
                            {{ $booking_service->taxes }}
                        </p>
                        <p>
                            <strong>{{ trans('lang.coupon') }}:</strong>
                            {{ $booking_service->coupon }}
                        </p>
                    </div>
                    <div class="col-md-7">
                        <p>
                            <strong>{{ trans('lang.address') }}:</strong>
                            {{ $booking_service->address?->address }}
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
