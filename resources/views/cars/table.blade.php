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
                <th>{{ trans('lang.slide_image') }}</th>
                <th>{{ trans('lang.tax_name') }}</th>
                <th>{{ trans('lang.category_updated_at') }}</th>
                <th>{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $car)
                <tr>
                    <td>
                        <img class="rounded image-thumbnail" alt="{{ trans('lang.category_image') }}"
                            src="{{ $car->media[0]->image ?? $noneImage }}">
                    </td>
                    <td>{{ $car->name }}</td>
                    <td>{{ $car->updated_at->diffForHumans() }}</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-toggle="tooltip" data-placement="left" href="{{ route('cars.edit', $car->id) }}"
                                class='btn btn-link'>
                                <i class="fas fa-edit"></i> </a>
                            {{-- {!! Form::open(['route' => ['cars.destroy', $car->id], 'method' => 'delete']) !!}
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
