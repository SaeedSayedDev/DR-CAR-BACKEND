@push('css_lib')
    @include('layouts.datatables_css')
@endpush

{{-- {!! $dataTable->table(['width' => '100%']) !!} --}}

@push('scripts_lib')
    @include('layouts.datatables_js')
    {{-- {!! $dataTable->scripts() !!} --}}
@endpush

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>{{ trans('lang.user') }}</th>
                <th>{{ trans('lang.nationality') }}</th>
                <th>{{ trans('lang.traffic_code_number') }}</th>
                <th>{{ trans('lang.traffic_plate_number') }}</th>
                <th>{{ trans('lang.expiry_date') }}</th>
                <th>{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $carLicense)
                <tr>
                    <td>
                        <a href="{{ route('users.user', $carLicense->user->id) }}">
                            {{ $carLicense->user->full_name }}
                        </a>
                    </td>
                    <td>{{ app()->getLocale() == 'ar' ? $carLicense->nationality_ar : $carLicense->nationality_en }}
                    </td>
                    <td>{{ $carLicense->traffic_code_number }}</td>
                    <td>{{ $carLicense->traffic_plate_number }}</td>
                    <td>{{ $carLicense->expiry_date }}</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-toggle="modal" data-target="#carLicenseDetailsModal{{ $carLicense->id }}"
                                title="{{ trans('lang.view_details') }}" href="">
                                <i class="fas fa-info-circle text-info text-md mr-3"></i>
                            </a>
                            @include('car_licenses.modal')
                            <a href="{{ route('carReports.report', $carLicense->id) }}"
                                title="{{ trans('lang.car_report_plural') }}">
                                <i class="fas fa-file-alt text-orange text-md"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $dataTable->links() }}
