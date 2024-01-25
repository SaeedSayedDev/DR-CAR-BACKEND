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
            <th>{{ trans('lang.coupon_code') }}</th>
            <th>{{ trans('lang.coupon_discount') }}</th>
            <th>{{ trans('lang.coupon_expires_at') }}</th>
            <th>{{ trans('lang.coupon_enabled') }}</th>
            <th>{{ trans('lang.coupon_updated_at') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $coupon)
            <tr>
                <td>{{ $coupon->coupon }}</td>
                <td>{{ $coupon->coupon_price }}%</td>
                <td>{{ $coupon->end_date }}</td>
                <td>
                    @if (now()->between($coupon->start_date, $coupon->end_date))
                        <span class="badge bg-success">{{ trans('lang.coupon_enabled') }}</span>
                    @else
                        <span class="badge bg-danger">{{ trans('lang.custom_field_disabled') }}</span>
                    @endif
                </td>
                <td>{{ $coupon->updated_at->diffForHumans() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}
