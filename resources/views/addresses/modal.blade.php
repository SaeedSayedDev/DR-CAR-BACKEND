<!-- Modal -->
<div class="modal fade" id="addressDetailsModal{{ $address->id }}" tabindex="-1" role="dialog"
    aria-labelledby="addressDetailsModalLabel{{ $address->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addressDetailsModalLabel{{ $address->id }}">
                    {{ $address->name }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <p>
                            <strong>{{ trans('lang.address_longitude') }}:</strong>
                            {{ $address->longitude }}
                        </p>
                        <p>
                            <strong>{{ trans('lang.address_latitude') }}:</strong>
                            {{ $address->latitude }}
                        </p>
                    </div>
                    <div class="col-md-7">
                        <p>
                            <strong>{{ trans('lang.address_description') }}:</strong>
                            {{ $address->description }}
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
