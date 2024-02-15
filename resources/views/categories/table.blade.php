{{-- @push('css_lib')
    @include('layouts.datatables_css')
@endpush

{!! $dataTable->table(['width' => '100%']) !!}

@push('scripts_lib')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
@endpush --}}

<table class="table">
    <thead>
        <tr class="text-center">
            <th>{{ trans('lang.category_image') }}</th>
            <th>{{ trans('lang.category_name') }}</th>
            <th>{{ trans('lang.category_description') }}</th>
            <th>{{ trans('lang.category_updated_at') }}</th>
            <th>{{ trans('lang.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $category)
            <tr>
                <td>
                    <img class="rounded" style="height:50px" alt="{{ trans('lang.category_image') }}"
                        src="{{ asset('storage/images/admin/categories/' . $category->media()->first()?->imageName()) }}">
                </td>
                <td>{{ $category->name }}</td>
                <td>{{ $category->desc }}</td>
                <td>{{ $category->updated_at->diffForHumans() }}</td>
                <td>
                    <div class='btn-group btn-group-sm'>
                        <a data-toggle="tooltip" data-placement="left" 
                            href="{{ route('categories.edit', $category->id) }}" class='btn btn-link'>
                            <i class="fas fa-edit"></i> </a>
                        {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'delete']) !!}
                        {!! Form::button('<i class="fas fa-trash"></i>', [
                            'type' => 'submit',
                            'class' => 'btn btn-link text-danger',
                            'onclick' => "return confirm('Are you sure?')",
                        ]) !!}
                        {!! Form::close() !!}
                        {{-- <a data-toggle="tooltip" data-placement="left" href="{{ route('categories.show', $category->id) }}"
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
