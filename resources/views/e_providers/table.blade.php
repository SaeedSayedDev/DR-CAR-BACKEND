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
                <th>{{ trans('lang.e_provider_name') }}</th>
                <th>{{ trans('lang.garage') }}</th>
                <th>{{ trans('lang.e_service') }}</th>
                <th>{{ trans('lang.address_updated_at') }}</th>
                <th>{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $eProvider)
                <tr>
                    <td>{{ $eProvider->name }}</td>
                    <td>
                        <a href="{{ route('users.user', $eProvider->user->id) }}">
                            {{ $eProvider->user->full_name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('eServices.service', $eProvider->checkService->id) }}">
                            {{ $eProvider->checkService->name }}
                        </a>
                    </td>
                    <td>{{ $eProvider->updated_at->diffForHumans() }}</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-toggle="tooltip" data-placement="left"
                                href="{{ route('eProviders.edit', $eProvider->id) }}" class='btn btn-link'>
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="" title="{{ trans('lang.view_details') }}" class='btn btn-link'
                                data-toggle="modal" data-target="#eProviderDetailsModal{{ $eProvider->id }}">
                                <i class="fas fa-info-circle text-info text-md"></i>
                            </a>
                            @include('e_providers.modal')
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $dataTable->links() }}
