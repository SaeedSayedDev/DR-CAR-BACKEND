{{-- @push('css_lib')
    @include('layouts.datatables_css')
@endpush

{!! $dataTable->table(['width' => '100%']) !!}

@push('scripts_lib')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush --}}

<table class="table">
    <thead>
        <tr class="text-center">
            <th>{{ trans('lang.booking_id') }}</th>
            <th>{{ trans('lang.booking_e_service') }}</th>
            <th>{{ trans('lang.booking_e_provider') }}</th>
            <th>{{ trans('lang.booking_user_id') }}</th>
            <th>{{ trans('lang.booking_address') }}</th>
            <th>{{ trans('lang.booking_booking_status_id') }}</th>
            <th>{{ trans('lang.payment_payment_status_id') }}</th>
            <th>{{ trans('lang.booking_taxes') }}</th>
            <th>{{ trans('lang.booking_coupon') }}</th>
            <th>{{ trans('lang.booking_total') }}</th>
            <th>{{ trans('lang.booking_booking_at') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $booking_service)
            <tr>
                <td>{{ $booking_service->id }}</td>
                <td>{{ $booking_service->service->name }}</td>
                <td>{{ $booking_service->service->provider->name }}</td>
                <td>{{ $booking_service->user->full_name }}</td>
                <td>{{ $booking_service->address?->address }}</td>
                <td>{{ $booking_service->status_order->name }}</td>
                <td>{{ $booking_service->payment_stataus }}</td>
                <td>{{ $booking_service->taxes }}</td>
                <td>{{ $booking_service->coupon }}</td>
                <td>{{ $booking_service->payment_amount }}</td>
                <td>{{ $booking_service->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}
