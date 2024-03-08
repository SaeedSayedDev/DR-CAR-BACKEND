<div class="modal fade" id="rejectModal{{ $booking_ad->id }}" tabindex="-1" role="dialog"
    aria-labelledby="rejectModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="rejectModalLabel">{{ trans('lang.reject') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal"
                    aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('booking.ads.reject', $booking_ad->id) }}">
                    @csrf

                    <div class="form-group">
                        <label
                            for="rejection_reason">{{ trans('lang.rejection_reason') }}</label>
                        <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-danger" onclick='return confirm("Are you sure?")'>
                        {{ trans('lang.reject') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
