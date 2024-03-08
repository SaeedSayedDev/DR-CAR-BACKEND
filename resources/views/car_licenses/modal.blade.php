<!-- Modal -->
<div class="modal fade" id="carLicenseDetailsModal{{ $carLicense->id }}" tabindex="-1" role="dialog"
    aria-labelledby="carLicenseDetailsModalLabel{{ $carLicense->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="carLicenseDetailsModalLabel{{ $carLicense->id }}">
                    {{ $carLicense->owner_en }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <!-- Display the first image -->
                        <img class="rounded image-modal mb-3" alt="{{ trans('lang.car_license_image') }}"
                            src="{{ $carLicense->media[0]->image }}">
                    </div>
                    <div class="col-md-6">
                        <!-- Display the second image -->
                        <img class="rounded image-modal mb-3" alt="{{ trans('lang.car_license_image') }}"
                            src="{{ $carLicense->media[1]->image }}">
                    </div>

                    <div class="col-md-6">
                        <!-- Display personal information -->
                        <p><strong>{{ trans('lang.owner') }} (EN):</strong> {{ $carLicense->owner_en }}</p>
                        <p><strong>{{ trans('lang.owner') }} (AR):</strong> {{ $carLicense->owner_ar }}</p>
                        <p><strong>{{ trans('lang.nationality') }} (EN):</strong> {{ $carLicense->nationality_en }}</p>
                        <p><strong>{{ trans('lang.nationality') }} (AR):</strong> {{ $carLicense->nationality_ar }}</p>
                        <p><strong>{{ trans('lang.number_of_passengers') }}:</strong> {{ $carLicense->number_of_passengers }}</p>
                        <p><strong>{{ trans('lang.model') }}:</strong> {{ $carLicense->model }}</p>
                        <p><strong>{{ trans('lang.origin') }} (EN):</strong> {{ $carLicense->origin_en }}</p>
                        <p><strong>{{ trans('lang.origin') }} (AR):</strong> {{ $carLicense->origin_ar }}</p>
                        <p><strong>{{ trans('lang.color') }}:</strong> {{ $carLicense->color }}</p>
                        <p><strong>{{ trans('lang.class') }}:</strong> {{ $carLicense->class }}</p>
                        <p><strong>{{ trans('lang.type') }} (EN):</strong> {{ $carLicense->type_en }}</p>
                        <p><strong>{{ trans('lang.type') }} (AR):</strong> {{ $carLicense->type_ar }}</p>
                    </div>
                    <div class="col-md-6">
                        <!-- Display license information -->
                        <p><strong>{{ trans('lang.gross_weight') }}:</strong> {{ $carLicense->gross_weight }}</p>
                        <p><strong>{{ trans('lang.empty_weight') }}:</strong> {{ $carLicense->empty_weight }}</p>
                        <p><strong>{{ trans('lang.engine_number') }}:</strong> {{ $carLicense->engine_number }}</p>
                        <p><strong>{{ trans('lang.chassis_number') }}:</strong> {{ $carLicense->chassis_number }}</p>
                        <p><strong>{{ trans('lang.traffic_code_number') }}:</strong> {{ $carLicense->traffic_code_number }}</p>
                        <p><strong>{{ trans('lang.traffic_plate_number') }}:</strong> {{ $carLicense->traffic_plate_number }}</p>
                        <p><strong>{{ trans('lang.plate_class') }}:</strong> {{ $carLicense->plate_class }}</p>
                        <p><strong>{{ trans('lang.place_of_issue') }}:</strong> {{ $carLicense->place_of_issue }}</p>
                        <p><strong>{{ trans('lang.expiry_date') }}:</strong> {{ $carLicense->expiry_date }}</p>
                        <p><strong>{{ trans('lang.registration_date') }}:</strong> {{ $carLicense->registration_date }}</p>
                        <p><strong>{{ trans('lang.insurance_expiry') }}:</strong> {{ $carLicense->insurance_expiry }}</p>
                        <p><strong>{{ trans('lang.policy_number') }}:</strong> {{ $carLicense->policy_number }}</p>
                        <p><strong>{{ trans('lang.insured_company') }}:</strong> {{ $carLicense->insured_company }}</p>
                        <p><strong>{{ trans('lang.insurance_type') }}:</strong> {{ $carLicense->insurance_type }}</p>
                        <p><strong>{{ trans('lang.mortgaged_by') }}:</strong> {{ $carLicense->mortgaged_by }}</p>
                        <p><strong>{{ trans('lang.notes') }}:</strong> {{ $carLicense->notes }}</p>
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
