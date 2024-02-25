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
                <th>{{ trans('lang.garage') }}</th>
                <th>{{ trans('lang.display_duration') }}</th>
                <th>{{ trans('lang.payment_amount') }}</th>
                <th>{{ trans('lang.display') }}</th>
                <th>{{ trans('lang.format') }}</th>
                <th>{{ trans('lang.booking_status') }}</th>
                <th>{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $booking_ad)
                <tr>
                    <td>{{ $booking_ad->garage->full_name }}</td>
                    <td>{{ $booking_ad->display_duration}} {{ trans('lang.days') }}</td>
                    <td>{{ $booking_ad->amount }}</td>
                    <td>{{ $booking_ad->display ? trans('lang.yes') : trans('lang.no') }}</td>
                    <td>
                        @if ($booking_ad->format === 0)
                            {{ trans('lang.text') }}
                        @elseif($booking_ad->format === 1)
                            {{ trans('lang.image') }}
                        @elseif($booking_ad->format === 2)
                            {{ trans('lang.video') }}
                        @endif
                    </td>
                    <td>
                        @if ($booking_ad->status === 0)
                            <span class="badge bg-warning">{{ trans('lang.pending') }}</span>
                        @elseif($booking_ad->status === 1)
                            <span class="badge bg-success">{{ trans('lang.approved') }}</span>
                        @elseif($booking_ad->status === 2)
                            <span class="badge bg-danger">{{ trans('lang.rejected') }}</span>
                        @endif
                    </td>
                    <td>
                        <a data-toggle="tooltip" data-placement="left"
                            href="{{ route('booking-ads.show', $booking_ad->id) }}" class='btn btn-link'>
                            <i class="fas fa-eye"></i>
                        </a>
                        @if ($booking_ad->status === 0)
                            <form action="{{ route('booking-ads.approve', $booking_ad->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-success btn-sm"
                                    title="{{ trans('lang.approve') }}" onclick='return confirm("Are you sure?")'>
                                    <i class="fas fa-check-circle"></i>
                                </button>
                            </form>
                            <button type="button" class="btn btn-danger btn-sm" title="{{ trans('lang.reject') }}"
                                data-toggle="modal" data-target="#rejectModal{{ $booking_ad->id }}">
                                <i class="fas fa-times-circle"></i>
                            </button>
                            <!-- Reject Modal -->
                            <div class="modal fade" id="rejectModal{{ $booking_ad->id }}" tabindex="-1" role="dialog"
                                aria-labelledby="rejectModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="rejectModalLabel">{{ trans('lang.reject') }}
                                            </h5>
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('booking-ads.reject', $booking_ad->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')

                                                <div class="form-group">
                                                    <label
                                                        for="rejection_reason">{{ trans('lang.rejection_reason') }}</label>
                                                    <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3" required></textarea>
                                                </div>
                                                <button type="submit" class="btn btn-danger"
                                                    onclick='return confirm("Are you sure?")'>{{ trans('lang.reject') }}</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
{{ $dataTable->links() }}
