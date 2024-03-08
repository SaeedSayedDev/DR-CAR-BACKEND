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
                <th>{{ trans('lang.user') }}</th>
                <th>{{ trans('lang.wallet') }}</th>
                <th>{{ trans('lang.wallet_transaction_amount') }}</th>
                <th>{{ trans('lang.wallet_transaction_action') }}</th>
                <th>{{ trans('lang.wallet_transaction_description') }}</th>
                <th>{{ trans('lang.wallet_transaction_updated_at') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $walletTransaction)
                <tr>
                    <td>
                        <a href="{{ route('users.user', $walletTransaction->user->id) }}">
                            {{ $walletTransaction->user->full_name }}
                        </a>
                    </td>
                    <td>
                        <a href="{{ route('wallets.wallet', $walletTransaction->wallet->id) }}">
                            {{ $walletTransaction->wallet->name }}
                        </a>
                    </td>
                    <td>{{ $walletTransaction->amount }}</td>
                    <td>{{ $walletTransaction->action }}</td>
                    <td>{{ $walletTransaction->description }}</td>
                    <td>{{ $walletTransaction->updated_at->diffForHumans() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $dataTable->links() }}
