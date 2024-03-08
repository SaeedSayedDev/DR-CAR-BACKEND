<!-- Modal -->
<div class="modal fade" id="serviceDetailsModal{{ $service->id }}" tabindex="-1" role="dialog"
    aria-labelledby="serviceDetailsModalLabel{{ $service->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="serviceDetailsModalLabel{{ $service->id }}">{{ $service->name }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <img class="rounded image-modal" alt="{{ trans('lang.category_image') }}"
                            src="{{ $service->media[0]->image ?? $noneImage }}">
                    </div>
                    <div class="col-md-7">
                        <p><strong>{{ trans('lang.coupon_discount') }}:</strong> {{ $service->discount_price }}</p>
                        <p>
                            <strong>{{ trans('lang.e_service_available') }}:</strong>
                            @if ($service->available)
                                <span class="badge bg-success">{{ trans('lang.yes') }}</span>
                            @else
                                <span class="badge bg-danger">{{ trans('lang.no') }}</span>
                            @endif
                        </p>
                        <p>
                            <strong>{{ trans('lang.e_service_price_unit') }}:</strong>
                            @if ($service->price_unit)
                                {{ trans('lang.tax_fixed') }}
                            @else
                                {{ trans('lang.hourly') }}
                            @endif
                        </p>
                        <p><strong>{{ trans('lang.e_service_quantity_unit') }}:</strong> {{ $service->quantity_unit }}
                        </p>
                        <p><strong>{{ trans('lang.e_service_duration') }}:</strong> {{ $service->duration }}</p>
                        <p>
                            <strong>{{ trans('lang.e_service_featured') }}:</strong>
                            @if ($service->featured)
                                <span class="badge bg-success">{{ trans('lang.yes') }}</span>
                            @else
                                <span class="badge bg-danger">{{ trans('lang.no') }}</span>
                            @endif
                        </p>
                        <p>
                            <strong>{!! trans('lang.e_service_enable_booking') !!}:</strong>
                            @if ($service->enable_booking)
                                <span class="badge bg-success">{{ trans('lang.yes') }}</span>
                            @else
                                <span class="badge bg-danger">{{ trans('lang.no') }}</span>
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary"
                    data-dismiss="modal">{{ trans('lang.close') }}</button>
            </div>
        </div>
    </div>
</div>
