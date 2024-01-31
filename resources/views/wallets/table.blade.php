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
            <th>{{ trans('lang.wallet_name') }}</th>
            <th>{{ trans('lang.wallet_balance') }}</th>
            <th>{{ trans('lang.earning') }}</th>
            <th>{{ trans('lang.awating_transfer') }}</th>
            <th>{{ trans('lang.user') }}</th>
            <th>{{ trans('lang.wallet_updated_at') }}</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataTable as $wallet)
            <tr class="text-center">
                <td>{{ $wallet->name }}</td>
                <td>{{ $wallet->total_balance }}</td>
                <td>{{ $wallet->total_earning }}</td>
                <td>{{ $wallet->awating_transfer }}</td>
                <td>{{ $wallet->user->full_name }}</td>
                <td>{{ $wallet->updated_at->diffForHumans() }}</td>
            </tr>
        @endforeach
    </tbody>
</table>

{{ $dataTable->links() }}