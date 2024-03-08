<!-- Modal -->
<div class="modal fade" id="carReportDetailsModal{{ $carReport->id }}" tabindex="-1" role="dialog"
    aria-labelledby="carReportDetailsModalLabel{{ $carReport->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="carReportDetailsModalLabel{{ $carReport->id }}">
                    {{ trans('lang.car_report_details') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>{{ trans('lang.changed_parts') }} :</strong> {{ $carReport->changed_parts }}</p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>{{ trans('lang.report_details') }}:</strong> {{ $carReport->report_details }}</p>
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
