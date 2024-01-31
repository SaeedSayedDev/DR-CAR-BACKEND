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
            <th>{{ trans('lang.wallet_transaction_amount') }}</th>
            <th>{{ trans('lang.wallet_transaction_description') }}</th>
            <th>{{ trans('lang.wallet_transaction_action') }}</th>
            <th>{{ trans('lang.wallet_transaction_wallet_id') }}</th>
            <th>{{ trans('lang.wallet_transaction_user_id') }}</th>
            <th>{{ trans('lang.wallet_transaction_updated_at') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $walletTransaction)
            <tr class="text-center">
                <td>{{ $walletTransaction->amount }}</td>
                <td>{{ $walletTransaction->description }}</td>
                <td>{{ $walletTransaction->action }}</td>
                <td>{{ $walletTransaction->wallet->name }}</td>
                <td>{{ $walletTransaction->user->name }}</td>
                <td>{{ $walletTransaction->updated_at->diffForHumans() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}