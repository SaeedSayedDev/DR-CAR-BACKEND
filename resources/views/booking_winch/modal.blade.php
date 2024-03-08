<!-- Modal -->
<div class="modal fade" id="bookingWinchDetailsModal{{ $booking_winch->id }}" tabindex="-1" role="dialog"
    aria-labelledby="bookingWinchDetailsModalLabel{{ $booking_winch->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookingWinchDetailsModalLabel{{ $booking_winch->id }}">
                    {{ trans('lang.booking_winch_details') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <p>
                            <strong>{{ trans('lang.type') }}:</strong>
                            {{ $booking_winch->payment_type }}
                        </p>
                    </div>
                    <div class="col-md-7">
                        <p>
                            <strong>{{ trans('lang.address') }}:</strong>
                            {{ $booking_winch->address->address }}
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
