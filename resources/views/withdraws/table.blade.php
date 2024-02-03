@push('css_lib')
    @include('layouts.datatables_css')
@endpush

{{-- {!! $dataTable->table(['width' => '100%']) !!} --}}

@push('scripts_lib')
    @include('layouts.datatables_js')
    {{-- {!! $dataTable->scripts() !!} --}}
@endpush

@include('partials.form_errors')

<table class="table">
    <thead>
        <tr class="text-center">
            <th>{{ trans('lang.user_name') }}</th>
            <th>{{ trans('lang.payment_amount') }}</th>
            <th>{{ trans('lang.payment_status') }}</th>
            <th>{{ trans('lang.tax_type') }}</th>
            <th>{{ trans('lang.wallet_updated_at') }}</th>
            <th>{{ trans('lang.actions') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $withdraw)
            @php
                $statusColor = match ($withdraw->status) {
                    'pending' => 'info',
                    'processing' => 'warning',
                    'paid' => 'success',
                    'unpaid' => 'danger',
                };
            @endphp
            <tr class="text-center">
                <td>{{ $withdraw->user->full_name }}</td>
                <td>{{ $withdraw->amount }}</td>
                <td>
                    <span class="badge bg-{{ $statusColor }}">
                        {{ trans("lang.$withdraw->status") }}
                    </span>
                </td>
                <td>{{ $withdraw->type }}</td>
                <td>{{ $withdraw->updated_at->diffForHumans() }}</td>
                <td>
                    <div class="btn-group" role="group">
                        <a data-toggle="tooltip" data-placement="left" href="{{ route('withdraws.show', $withdraw->id) }}"
                            class='btn btn-link'>
                            <i class="fas fa-eye"></i>
                        </a>
                        @if ($withdraw->status == 'pending' || $withdraw->status == 'processing')
                            <div class="dropdown">
                                <button class="btn btn-link dropdown-toggle" type="button" id="statusDropdown"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-cog"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                    <form action="{{ route('withdraws.status.update', $withdraw->id) }}" method="post">
                                        @csrf
                                        @method('put')
                                        @if ($withdraw->status == 'pending')
                                            <button type="submit" class="dropdown-item" name="status" value="processing">
                                                <i class="fas fa-circle text-warning"></i> {{ trans('lang.processing') }}
                                            </button>
                                        @endif
                                        <button type="submit" class="dropdown-item" name="status" value="paid">
                                            <i class="fas fa-circle text-success"></i> {{ trans('lang.paid') }}
                                        </button>
                                        <button type="submit" class="dropdown-item" name="status" value="unpaid">
                                            <i class="fas fa-circle text-danger"></i> {{ trans('lang.unpaid') }}
                                        </button>
                                    </form>
                                </div>                                
                            </div>
                        @endif
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}
