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
            <th>{{ trans('lang.e_provider_image') }}</th>
            <th>{{ trans('lang.e_provider_name') }}</th>
            <th>{{ trans('lang.e_provider_e_provider_type_id') }}</th>
            <th>{{ trans('lang.e_provider_users') }}</th>
            <th>{{ trans('lang.e_provider_phone_number') }}</th>
            <th>{{ trans('lang.e_provider_addresses') }}</th>
            <th>{{ trans('lang.e_provider_availability_range') }}</th>
            <th>{{ trans('lang.e_provider_taxes') }}</th>
            <th>{{ trans('lang.address_updated_at') }}</th>
            <th>{{ trans('lang.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $eProvider)
            <tr>
                <td>
                    <img class="rounded" style="height:50px" alt="{{ trans('lang.e_provider_image') }}"
                        src="{{ asset('storage/images/providers/' . $eProvider->media()?->first()?->image) }}">
                </td>
                <td>{{ $eProvider->name }}</td>
                <td>{{ $eProvider->garage_type == 0 ? trans('lang.private') : trans('lang.company') }}</td>
                <td>{{ $eProvider->user->full_name }}</td>
                <td>{{ $eProvider->user->garage_information?->phone_number }}</td>
                <td>{{ $eProvider->address->address }}</td>
                <td>{{ $eProvider->availability_range }}</td>
                <td>{{ $eProvider->taxe->value }}</td>
                <td>{{ $eProvider->updated_at->diffForHumans() }}</td>
                <td>
                    <div class='btn-group btn-group-sm'>
                        <a data-toggle="tooltip" data-placement="left" title="{{ trans('lang.address_edit') }}"
                            href="{{ route('eProviders.edit', $eProvider->id) }}" class='btn btn-link'>
                            <i class="fas fa-edit"></i> </a>
                        {!! Form::open(['route' => ['eProviders.destroy', $eProvider->id], 'method' => 'delete']) !!}
                        {!! Form::button('<i class="fas fa-trash"></i>', [
                            'type' => 'submit',
                            'class' => 'btn btn-link text-danger',
                            'onclick' => "return confirm('Are you sure?')",
                        ]) !!}
                        {!! Form::close() !!}
                        <a data-toggle="tooltip" data-placement="left" href="{{ route('eProviders.show', $eProvider->id) }}"
                            class='btn btn-link'>
                            <i class="fas fa-eye"></i>
                        </a>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}
