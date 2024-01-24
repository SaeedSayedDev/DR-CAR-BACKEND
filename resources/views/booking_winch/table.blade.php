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
            <th>{{ trans('lang.booking_user_id') }}</th>
            <th>{{ trans('lang.winch') }}</th>
            <th>{{ trans('lang.booking_address') }}</th>
            <th>{{ trans('lang.payment_payment_status_id') }}</th>
            <th>{{ trans('lang.booking_total') }}</th>
            <th>{{ trans('lang.booking_booking_at') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $booking_winch)
            <tr>
                <td>{{ $booking_winch->id }}</td>
                <td>{{ $booking_winch->bookingService->service->name }}</td>
                <td>{{ $booking_winch->user->full_name }}</td>
                <td>{{ $booking_winch->winch->full_name }}</td>
                <td>{{ $booking_winch->address->address }}</td>
                <td>{{ $booking_winch->payment_stataus }}</td>
                <td>{{ $booking_winch->payment_amount }}</td>
                <td>{{ $booking_winch->created_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}
