@push('css_lib')
    @include('layouts.datatables_css')
@endpush

{{-- {!! $dataTable->table(['width' => '100%']) !!} --}}

@push('scripts_lib')
    @include('layouts.datatables_js')
    {{-- {!! $dataTable->scripts() !!} --}}
@endpush

<table class="table">
    <thead>
        <tr>
            <th>{{ trans('lang.tax_type') }}</th>
            <th>{{ trans('lang.per') }}</th>
            <th>{{ trans('lang.payment_amount') }}</th>
            <th>{{ trans('lang.category_updated_at') }}</th>
            <th>{{ trans('lang.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $price)
            <tr>
                <td>{{ $price->type }}</td>
                <td>{{ $price->per }}</td>
                <td>$ {{ $price->amount }}</td>
                <td>{{ $price->updated_at->diffForHumans() }}</td>
                <td>
                    <div class='btn-group btn-group-sm'>
                        <a data-toggle="tooltip" data-placement="left" href="{{ route('prices.edit', $price->id) }}"
                            class='btn btn-link'>
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}
