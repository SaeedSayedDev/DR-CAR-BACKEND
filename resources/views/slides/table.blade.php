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
        <tr>
            <th>{{ trans('lang.slide_image') }}</th>
            <th>{{ trans('lang.slide_order') }}</th>
            <th>{{ trans('lang.slide_text') }}</th>
            <th>{{ trans('lang.e_service') }}</th>
            <th>{{ trans('lang.category_updated_at') }}</th>
            <th>{{ trans('lang.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $slide)
            <tr>
                <td>
                    <img class="rounded" style="height:50px" alt="{{ trans('lang.category_image') }}"
                        src="{{ asset('storage/images/admin/slides/' . $slide->media()->first()?->imageName()) }}">
                </td>
                <td>{{ $slide->order }}</td>
                <td>{{ $slide->text }}</td>
                <td>{{ $slide->service->name }}</td>
                <td>{{ $slide->updated_at->diffForHumans() }}</td>
                <td>
                    <div class='btn-group btn-group-sm'>
                        <a data-toggle="tooltip" data-placement="left" 
                            href="{{ route('slides.edit', $slide->id) }}" class='btn btn-link'>
                            <i class="fas fa-edit"></i> </a>
                        {!! Form::open(['route' => ['slides.destroy', $slide->id], 'method' => 'delete']) !!}
                        {!! Form::button('<i class="fas fa-trash"></i>', [
                            'type' => 'submit',
                            'class' => 'btn btn-link text-danger',
                            'onclick' => "return confirm('Are you sure?')",
                        ]) !!}
                        {!! Form::close() !!}
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}