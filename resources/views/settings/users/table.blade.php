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
            <th>{{ trans('lang.user_avatar') }}</th>
            <th>{{ trans('lang.user_name') }}</th>
            <th>{{ trans('lang.user_email') }}</th>
            <th>{{ trans('lang.user_role_id') }}</th>
            <th>{{ trans('lang.user_updated_at') }}</th>
            <th>{{ trans('lang.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $user)
            <tr>
                <td>
                    <img class="rounded" style="height:50px" alt="{{ trans('lang.category_image') }}"
                        src="{{ asset('storage/images/accounts/' . $user->media()->first()?->imageName()) }}">
                </td>
                <td>{{ $user->full_name }}</td>
                <td>
                    <a class="btn btn-outline-secondary btn-sm" href="mailto:admin@demo.com">
                        <i class="fa fa-envelope mr-1"></i>{{ $user->email }}</a>
            </td>
                <td>
                    <span class="badge bg-primary">
                        {{ $user->role_id == 2 ? trans('lang.customer') : trans('lang.e_provider') }}
                    </span>
                </td>
                <td>{{ $user->updated_at->diffForHumans() }}</td>
                <td>
                    <div class='btn-group btn-group-sm'>
                        <a data-toggle="tooltip" data-placement="left" 
                            href="{{ route('users.edit', $user->id) }}" class='btn btn-link'>
                            <i class="fas fa-edit"></i> </a>
                        {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                        {!! Form::button('<i class="fas fa-trash"></i>', [
                            'type' => 'submit',
                            'class' => 'btn btn-link text-danger',
                            'onclick' => "return confirm('Are you sure?')",
                        ]) !!}
                        {!! Form::close() !!}
                        {{-- <a data-toggle="tooltip" data-placement="left" href="{{ route('users.show', $user->id) }}"
                            class='btn btn-link'>
                            <i class="fas fa-eye"></i>
                        </a> --}}
                        @if ($user->ban)
                            {!! Form::open(['route' => ['users.unban', $user->id], 'method' => 'put']) !!}
                            {!! Form::button('<i class="fas fa-check-circle"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-link text-success',
                                'onclick' => "return confirm('Are you sure?')",
                                'title' => 'unban',
                            ]) !!}
                            {!! Form::close() !!}
                        @else
                            {!! Form::open(['route' => ['users.ban', $user->id], 'method' => 'put']) !!}
                            {!! Form::button('<i class="fas fa-times-circle"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-link text-danger',
                                'onclick' => "return confirm('Are you sure?')",
                                'title' => 'ban',
                            ]) !!}
                            {!! Form::close() !!}
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}
