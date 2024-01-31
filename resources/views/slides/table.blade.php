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
            <th>{{ trans('lang.slide_order') }}</th>
            <th>{{ trans('lang.slide_text') }}</th>
            <th>{{ trans('lang.category_updated_at') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $slide)
            <tr class="text-center">
                <td>{{ $slide->order }}</td>
                <td>{{ $slide->text }}</td>
                <td>{{ $slide->updated_at->diffForHumans() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}