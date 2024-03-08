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
                <th>{{ trans('lang.user') }}</th>
                <th>{{ trans('lang.address_address') }}</th>
                <th>{{ trans('lang.address_updated_at') }}</th>
                <th>{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $address)
                <tr>
                    <td>
                        <a href="{{ route('users.user', $address->user->id) }}">
                            {{ $address->user->full_name }}
                        </a>
                    </td>
                    <td>{{ $address->address }}</td>
                    <td>{{ $address->updated_at->diffForHumans() }}</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-toggle="tooltip" data-placement="left"
                                href="{{ route('addresses.edit', $address->id) }}" class='btn btn-link'>
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="" title="{{ trans('lang.view_details') }}" class='btn btn-link'
                                data-toggle="modal" data-target="#addressDetailsModal{{ $address->id }}">
                                <i class="fas fa-info-circle text-info text-md"></i>
                            </a>
                            @include('addresses.modal')
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $dataTable->links() }}
