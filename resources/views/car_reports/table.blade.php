@push('css_lib')
    @include('layouts.datatables_css')
@endpush

@push('scripts_lib')
    @include('layouts.datatables_js')
@endpush

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>{{ trans('lang.user') }}</th>
                <th>{{ trans('lang.garage') }}</th>
                <th>{{ trans('lang.maintenance_type') }}</th>
                <th>{{ trans('lang.maintenance_date') }}</th>
                <th>{{ trans('lang.parts_changed') }}</th>
                <th>{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $carReport)
                <tr>
                    <td>
                        <a href="{{ route('users.user', $carReport->carLicense->user->id) }}">
                            {{ $carReport->carLicense->user->full_name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('users.user', $carReport->garage->id) }}">
                            {{ $carReport->garage->full_name }}
                        </a>
                    </td>
                    <td>{{ $carReport->maintenance_type }}</td>
                    <td>{{ $carReport->maintenance_date }}</td>
                    <td>
                        @if ($carReport->parts_changed)
                            <span class="badge bg-success">{{ trans('lang.yes') }}</span>
                        @else
                            <span class="badge bg-danger">{{ trans('lang.no') }}</span>
                        @endif
                    </td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-toggle="modal" data-target="#carReportDetailsModal{{ $carReport->id }}"
                                title="{{ trans('lang.view_details') }}" href="">
                                <i class="fas fa-info-circle text-info text-md mr-3"></i>
                            </a>
                            @include('car_reports.modal')
                            @if ($carReport->media_exists)
                                <a href="{{ route('carReports.attachments', $carReport->id) }}" class='btn btn-link'
                                    title="{{ trans('lang.attachment_plural') }}">
                                    <i class="fas fa-paperclip"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $dataTable->links() }}
