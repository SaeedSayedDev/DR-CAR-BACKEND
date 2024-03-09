@push('css_lib')
    @include('layouts.datatables_css')
@endpush

{{-- {!! $dataTable->table(['width' => '100%']) !!} --}}

@push('scripts_lib')
    @include('layouts.datatables_js')
    {{-- {!! $dataTable->scripts() !!} --}}
@endpush

@include('partials.request_errors')

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>{{ trans('lang.user_name') }}</th>
                <th>{{ trans('lang.payment_amount') }}</th>
                <th>{{ trans('lang.tax_type') }}</th>
                <th>{{ trans('lang.payment_status') }}</th>
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
                <tr>
                    <td>
                        <a href="{{ route('users.user', $withdraw->user->id) }}">
                            {{ $withdraw->user->full_name }}
                        </a>
                    </td>
                    <td>{{ $withdraw->amount }}</td>
                    <td>
                        @if ($withdraw->type == 1)
                            {{ trans('lang.credit') }}
                        @elseif ($withdraw->type == 2)
                            {{ trans('lang.paypal') }}
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-{{ $statusColor }}">
                            {{ trans("lang.$withdraw->status") }}
                        </span>
                    </td>
                    <td>{{ $withdraw->updated_at->diffForHumans() }}</td>
                    <td>
                        <div class="btn-group" role="group">
                            @if ($withdraw->status == 'pending' || $withdraw->status == 'processing')
                                <div class="dropdown">
                                    <button class="btn btn-link dropdown-toggle" type="button" id="statusDropdown"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-cog"></i>
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="statusDropdown">
                                        <form action="{{ route('withdraws.status.update', $withdraw->id) }}"
                                            method="post">
                                            @csrf
                                            @method('put')
                                            @if ($withdraw->status == 'pending')
                                                <button type="submit" class="dropdown-item" name="status"
                                                    value="processing">
                                                    <i class="fas fa-circle text-warning"></i>
                                                    {{ trans('lang.processing') }}
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
</div>

{{ $dataTable->links() }}
