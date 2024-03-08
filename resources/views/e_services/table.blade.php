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
                <th>{{ trans('lang.e_service_image') }}</th>
                <th>{{ trans('lang.e_service_name') }}</th>
                <th>{{ trans('lang.e_service_price') }}</th>
                <th>{{ trans('lang.e_provider') }}</th>
                <th>{{ trans('lang.status') }}</th>
                <th>{{ trans('lang.e_service_updated_at') }}</th>
                <th>{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $service)
                <tr>
                    <td>
                        <img class="rounded image-fixed" alt="{{ trans('lang.category_image') }}"
                            src="{{ $service->media[0]->image ?? $noneImage }}">
                    </td>
                    <td>{{ $service->name }}</td>
                    <td>{{ $service->price }}</td>
                    <td>
                        <a href="{{ route('eProviders.provider', $service->provider->id) }}">
                            {{ $service->provider->name }}
                        </a>
                    </td>
                    <td>
                        @if ($service->status == 0)
                            <span class="badge bg-warning">{{ trans('lang.pending') }}</span>
                        @elseif($service->status == 1)
                            <span class="badge bg-success">{{ trans('lang.approved') }}</span>
                        @elseif($service->status == 2)
                            <span class="badge bg-danger">{{ trans('lang.rejected') }}</span>
                        @endif
                    </td>
                    <td>{{ $service->updated_at->diffForHumans() }}</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-toggle="tooltip" data-placement="left"
                                href="{{ route('eServices.edit', $service->id) }}" class='btn btn-link'>
                                <i class="fas fa-edit"></i>
                            </a>
                            {{-- {!! Form::open(['route' => ['eServices.destroy', $service->id], 'method' => 'delete']) !!}
                        {!! Form::button('<i class="fas fa-trash"></i>', [
                            'type' => 'submit',
                            'class' => 'btn btn-link text-danger',
                            'onclick' => "return confirm('Are you sure?')",
                        ]) !!}
                        {!! Form::close() !!} --}}
                            <a href="" title="{{ trans('lang.view_details') }}" class='btn btn-link'
                                data-toggle="modal" data-target="#serviceDetailsModal{{ $service->id }}">
                                <i class="fas fa-info-circle text-info text-md"></i>
                            </a>
                            @include('e_services.modal')
                            @if ($service->status == 0)
                                <a href="{{ route('eServices.approve', $service->id) }}"
                                    title="{{ trans('lang.approve') }}" class='btn btn-link'
                                    onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-check-circle text-success text-md"></i>
                                </a>

                                <a href="{{ route('eServices.reject', $service->id) }}"
                                    title="{{ trans('lang.reject') }}" class='btn btn-link'
                                    onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-times-circle text-danger text-md"></i>
                                </a>
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $dataTable->links() }}
