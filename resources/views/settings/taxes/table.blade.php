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
                <th>{{ trans('lang.tax_name') }}</th>
                <th>{{ trans('lang.tax_value') }}</th>
                <th>{{ trans('lang.tax_type') }}</th>
                <th>{{ trans('lang.tax_updated_at') }}</th>
                <th>{{ trans('lang.actions') }}</th>
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
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-toggle="tooltip" data-placement="left" href="{{ route('taxes.edit', $tax->id) }}"
                                class='btn btn-link'>
                                <i class="fas fa-edit"></i> </a>
                            {{-- {!! Form::open(['route' => ['taxes.destroy', $tax->id], 'method' => 'delete']) !!}
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
