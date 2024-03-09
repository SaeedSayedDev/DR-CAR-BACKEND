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
                <th>{{ trans('lang.coupon_code') }}</th>
                <th>{{ trans('lang.tax_type') }}</th>
                <th>{{ trans('lang.coupon_discount') }}</th>
                <th>{{ trans('lang.coupon_expires_at') }}</th>
                <th>{{ trans('lang.coupon_enabled') }}</th>
                <th>{{ trans('lang.coupon_updated_at') }}</th>
                <th>{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $coupon)
                <tr>
                    <td>{{ $coupon->coupon }}</td>
                    <td>
                        <span class="badge bg-primary">
                            {{ $coupon->coupon_unit ? trans('lang.tax_percent') : trans('lang.tax_fixed') }}
                        </span>
                    </td>
                    <td>{{ $coupon->coupon_price . ($coupon->coupon_unit ? ' %' : '') }}</td>
                    <td>{{ $coupon->end_date->format('d/m/Y H:i') }}</td>
                    <td>
                        @if (now()->between($coupon->start_date, $coupon->end_date))
                            <span class="badge bg-success">{{ trans('lang.coupon_enabled') }}</span>
                        @else
                            <span class="badge bg-danger">{{ trans('lang.coupon_disabled') }}</span>
                        @endif
                    </td>
                    <td>{{ $coupon->updated_at->diffForHumans() }}</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-toggle="tooltip" data-placement="left" href="{{ route('coupons.edit', $coupon->id) }}"
                                class='btn btn-link'>
                                <i class="fas fa-edit"></i> </a>
                            {{-- {!! Form::open(['route' => ['coupons.destroy', $coupon->id], 'method' => 'delete']) !!}
                        {!! Form::button('<i class="fas fa-trash"></i>', [
                            'type' => 'submit',
                            'class' => 'btn btn-link text-danger',
                            'onclick' => "return confirm('Are you sure?')",
                        ]) !!}
                        {!! Form::close() !!} --}}
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $dataTable->links() }}
