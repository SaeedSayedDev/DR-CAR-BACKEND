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
            <th>{{ trans('lang.tax_name') }}</th>
            <th>{{ trans('lang.tax_value') }}</th>
            <th>{{ trans('lang.tax_type') }}</th>
            <th>{{ trans('lang.tax_updated_at') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $tax)
            <tr>
                <td>{{ $tax->name }}</td>
                <td>{{ $tax->value }}</td>
                <td>
                    <span class="badge bg-primary">
                        {{ $tax->type ? trans('lang.tax_percent') : trans('lang.tax_fixed') }}
                    </span>
                </td>
                <td>{{ $tax->updated_at->diffForHumans() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}
