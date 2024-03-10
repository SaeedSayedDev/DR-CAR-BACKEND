<!-- Modal -->
<div class="modal fade" id="eProviderDetailsModal{{ $eProvider->id }}" tabindex="-1" role="dialog"
    aria-labelledby="eProviderDetailsModalLabel{{ $eProvider->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="eProviderDetailsModalLabel{{ $eProvider->id }}">
                    {{ $eProvider->name }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <p>
                            <strong>{{ trans('lang.e_provider_availability_range') }}:</strong>
                            {{ $eProvider->availability_range }}
                        </p>
                        <p>
                            <strong>{{ trans('lang.tax') }}:</strong>
                            {{ $eProvider->taxe->value }}
                        </p>
                    </div>
                    <div class="col-md-7">
                        <p>
                            <strong>{{ trans('lang.user_phone_number') }}:</strong>
                            {{ $eProvider->user->garage_information?->phone_number }}
                        </p>
                        <p>
                            <strong>{{ trans('lang.address') }}:</strong>
                            {{ $eProvider->address->address }}
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
