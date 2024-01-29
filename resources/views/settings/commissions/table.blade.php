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
        <tr class="text-center">
            <th>{{ trans('lang.commission') }}</th>
            <th>{{ trans('lang.tax_type') }}</th>
            <th>{{ trans('lang.by') }}</th>
            <th>{{ trans('lang.tax_updated_at') }}</th>
            <th>{{ trans('lang.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $commission)
            <tr class="text-center">
                <td>{{ number_format($commission->commission, 2) }}</td>
                <td>
                    <span class="badge bg-primary">{{ $commission->type ? trans('lang.tax_percent') : trans('lang.tax_fixed') }}</span>
                </td>
                <td>
                    <span class="badge bg-primary">{{ $commission->commission_from ? trans('lang.garage') : trans('lang.user') }}</span>
                </td>
                <td>{{ $commission->updated_at->diffForHumans() }}</td>
                <td>
                    <div class='btn-group btn-group-sm'>
                        <a data-toggle="tooltip" data-placement="left" class='btn btn-link'
                            href="{{ route('commissions.edit', $commission->id) }}">
                            <i class="fas fa-edit"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}
