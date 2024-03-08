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
                <th>{{ trans('lang.category_image') }}</th>
                <th>{{ trans('lang.category_name') }}</th>
                <th>{{ trans('lang.privacy') }}</th>
                <th>{{ trans('lang.category_updated_at') }}</th>
                <th>{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $category)
                <tr>
                    <td>
                        <img class="rounded image-thumbnail" alt="{{ trans('lang.category_image') }}"
                            src="{{ $category->media[0]->image ?? $noneImage }}">
                    </td>
                    <td>{{ $category->name }}</td>
                    <td>
                        @if ($category->public)
                            <span class="badge bg-success">{{ trans('lang.public') }}</span>
                        @else
                            <span class="badge bg-danger">{{ trans('lang.private') }}</span>
                        @endif
                    </td>
                    <td>{{ $category->updated_at->diffForHumans() }}</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-toggle="tooltip" data-placement="left"
                                href="{{ route('categories.edit', $category->id) }}" class='btn btn-link'>
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="" title="{{ trans('lang.view_details') }}" class='btn btn-link'
                                data-toggle="modal" data-target="#categoryDetailsModal{{ $category->id }}">
                                <i class="fas fa-info-circle text-info text-md"></i>
                            </a>
                            @include('categories.modal')
                            {{-- {!! Form::open(['route' => ['categories.destroy', $category->id], 'method' => 'delete']) !!}
                        {!! Form::button('<i class="fas fa-trash"></i>', [
                            'type' => 'submit',
                            'class' => 'btn btn-link text-danger',
                            'onclick' => "return confirm('Are you sure?')",
                        ]) !!}
                        {!! Form::close() !!} --}}
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
</div>

{{ $dataTable->links() }}
