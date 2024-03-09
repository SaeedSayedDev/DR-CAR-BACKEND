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
            <th>{{ trans('lang.creator') }}</th>
            <th>{{ trans('lang.user') }}</th>
            <th>{{ trans('lang.notification_title') }}</th>
            <th>{{ trans('lang.details') }}</th>
            <th>{{ trans('lang.notification_read') }}</th>
            <th>{{ trans('lang.notification_updated_at') }}</th>
            <th>{{ trans('lang.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $notification)
            <tr>
                <td>{{ $notification->creator_name }}</td>
                <td>{{ $notification->user->full_name }}</td>
                <td>{{ app()->getLocale() == 'ar' ? $notification->notification_type_ar : $notification->notification_type_en }}</td>
                <td>{{ app()->getLocale() == 'ar' ? $notification->text_ar : $notification->text_en }}</td>
                <td>
                    @if($notification->read)
                        <span class="badge bg-success">{{ trans('lang.yes') }}</span>
                    @else
                        <span class="badge bg-danger">{{ trans('lang.no') }}</span>
                    @endif
                </td>
                <td>{{ $notification->updated_at->diffForHumans() }}</td>
                <td>
                    <div class='btn-group btn-group-sm'>
                        {!! Form::open(['route' => ['notifications.destroy', $notification->id], 'method' => 'delete']) !!}
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
