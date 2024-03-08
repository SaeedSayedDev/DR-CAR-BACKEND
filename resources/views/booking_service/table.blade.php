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
                <th>{{ trans('lang.booking_e_service') }}</th>
                <th>{{ trans('lang.booking_e_provider') }}</th>
                <th>{{ trans('lang.booking_booking_status_id') }}</th>
                <th>{{ trans('lang.payment_payment_status_id') }}</th>
                <th>{{ trans('lang.booking_total') }}</th>
                <th>{{ trans('lang.booking_booking_at') }}</th>
                <th>{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $booking_service)
                <tr>
                    <td>
                        <a href="{{ route('users.user', $booking_service->user->id) }}">
                            {{ $booking_service->user->full_name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('eServices.service', $booking_service->service->id) }}">
                            {{ $booking_service->service->name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('eProviders.provider', $booking_service->service->provider->id) }}">
                            {{ $booking_service->service->provider->name }}
                        </a>
                    </td>
                    <td>{{ $booking_service->status_order->name }}</td>
                    <td>{{ $booking_service->payment_stataus }}</td>
                    <td>{{ $booking_service->payment_amount }}</td>
                    <td>{{ $booking_service->created_at->diffForHumans() }}</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a href="" title="{{ trans('lang.view_details') }}" class='btn btn-link'
                                data-toggle="modal" data-target="#bookingDetailsModal{{ $booking_service->id }}">
                                <i class="fas fa-info-circle text-info text-md"></i>
                            </a>
                            @include('booking_service.modal')
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $dataTable->links() }}
