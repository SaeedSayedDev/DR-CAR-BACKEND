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
                <th>
                    <input type="checkbox" id="selectAllCheckboxes">
                </th>
                <th>{{ trans('lang.user_avatar') }}</th>
                <th>{{ trans('lang.user_name') }}</th>
                <th>{{ trans('lang.user_role_id') }}</th>
                <th>{{ trans('lang.user_email') }}</th>
                <th class="w-25">{{ trans('lang.own') }}</th>
                <th>{{ trans('lang.user_updated_at') }}</th>
                <th class="text-center">{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $user)
                <tr>
                    <td>
                        <input type="checkbox" class="userCheckbox" value="{{ $user->id }}">
                    </td>
                    <td>
                        <img class="image-special" alt="{{ trans('lang.category_image') }}"
                            src="{{ $user->media->image ?? $noneImage }}">
                    </td>
                    <td>{{ $user->full_name }}</td>
                    <td>
                        <span class="badge bg-primary">
                            @if ($user->role_id == 2)
                                {{ trans('lang.customer') }}
                            @elseif ($user->role_id == 3)
                                {{ trans('lang.winch') }}
                            @elseif ($user->role_id == 4)
                                {{ trans('lang.garage') }}
                            @endif
                        </span>
                    </td>
                    <td>
                        <a class="btn btn-outline-secondary btn-sm" href="mailto:admin@demo.com">
                            <i class="fa fa-envelope mr-1"></i>{{ $user->email }}</a>
                    </td>
                    <td>
                        @if ($user->role_id == 2 && $user->carLicense)
                            <a href="{{ route('carLicenses.user', $user->id) }}"
                                title="{{ trans('lang.car_license_details') }}">
                                <i class="fas fa-id-card"></i>
                            </a>
                        @elseif ($user->role_id == 4 && $user->garage_data)
                            <a href="{{ route('eServices.user', $user->id) }}"
                                title="{{ trans('lang.e_service_details') }}">
                                <i class="fas fa-pencil-ruler"></i>
                            </a>
                        @endif
                        @if ($user->wallet)
                            <a href="{{ route('wallets.wallet', $user->wallet->id) }}"
                                title="{{ trans('lang.car_license_details') }}">
                                <i class="fas fa-wallet"></i>
                            </a>
                        @endif
                    </td>
                    <td>{{ $user->updated_at->diffForHumans() }}</td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a data-toggle="tooltip" data-placement="left" href="{{ route('users.edit', $user->id) }}"
                                class='btn btn-link'>
                                <i class="fas fa-edit"></i>
                            </a>
                            {!! Form::open(['route' => ['users.destroy', $user->id], 'method' => 'delete']) !!}
                            {!! Form::button('<i class="fas fa-trash"></i>', [
                                'type' => 'submit',
                                'class' => 'btn btn-link text-danger',
                                'onclick' => "return confirm('Are you sure?')",
                            ]) !!}
                            {!! Form::close() !!}
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
                            <a href="{{ route('users.show', $user->id) }}" class='btn btn-link' data-toggle="tooltip"
                                data-placement="left">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $dataTable->links() }}
