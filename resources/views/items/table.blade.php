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
            <th>{{ trans('lang.category_image') }}</th>
            <th>{{ trans('lang.category_name') }}</th>
            <th>{{ trans('lang.category_description') }}</th>
            <th>{{ trans('lang.category') }}</th>
            <th>{{ trans('lang.category_updated_at') }}</th>
            <th>{{ trans('lang.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $item)
            <tr>
                <td>
                    <img class="rounded" style="height:50px" alt="{{ trans('lang.category_image') }}"
                        src="{{ asset('storage/images/admin/items/' . $item->media()->first()?->imageName()) }}">
                </td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->desc }}</td>
                <td>{{ $item->category->name }}</td>
                <td>{{ $item->updated_at->diffForHumans() }}</td>
                <td>
                    <div class='btn-group btn-group-sm'>
                        <a data-toggle="tooltip" data-placement="left" 
                            href="{{ route('items.edit', $item->id) }}" class='btn btn-link'>
                            <i class="fas fa-edit"></i> </a>
                        {!! Form::open(['route' => ['items.destroy', $item->id], 'method' => 'delete']) !!}
                        {!! Form::button('<i class="fas fa-trash"></i>', [
                            'type' => 'submit',
                            'class' => 'btn btn-link text-danger',
                            'onclick' => "return confirm('Are you sure?')",
                        ]) !!}
                        {!! Form::close() !!}
                        {{-- <a data-toggle="tooltip" data-placement="left" href="{{ route('items.show', $item->id) }}"
                            class='btn btn-link'>
                            <i class="fas fa-eye"></i>
                        </a> --}}
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}
