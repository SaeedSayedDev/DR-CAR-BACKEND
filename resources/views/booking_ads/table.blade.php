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
                <th>{{ trans('lang.image') }}</th>
                <th>{{ trans('lang.garage') }}</th>
                <th>{{ trans('lang.display_duration') }}</th>
                <th>{{ trans('lang.payment_amount') }}</th>
                <th>{{ trans('lang.display') }}</th>
                <th>{{ trans('lang.booking_status') }}</th>
                <th>{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $booking_ad)
                <tr>
                    <td>
                        <img class="rounded image-thumbnail" alt="{{ trans('lang.category_image') }}"
                            src="{{ $booking_ad->media[0]->image ?? $noneImage }}">
                    </td>
                    <td>
                        <a href="{{ route('users.user', $booking_ad->garage->id) }}">
                            {{ $booking_ad->garage->full_name }}
                        </a>
                    </td>
                    <td>{{ $booking_ad->display_duration }} {{ trans('lang.days') }}</td>
                    <td>{{ $booking_ad->amount }}</td>
                    <td>
                        @if ($booking_ad->display)
                            <span class="badge bg-success">{{ trans('lang.yes') }}</span>
                        @else
                            <span class="badge bg-danger">{{ trans('lang.no') }}</span>
                        @endif
                    </td>
                    <td>
                        @if ($booking_ad->status == 0)
                            <span class="badge bg-warning">{{ trans('lang.pending') }}</span>
                        @elseif($booking_ad->status == 1)
                            <span class="badge bg-success">{{ trans('lang.approved') }}</span>
                        @elseif($booking_ad->status == 2)
                            <span class="badge bg-danger">{{ trans('lang.rejected') }}</span>
                        @elseif($booking_ad->status == 3)
                            <span class="badge bg-secondary">{{ trans('lang.refunded') }}</span>
                        @endif
                    </td>
                    <td>
                        <div class='btn-group btn-group-sm'>
                            <a href="" title="{{ trans('lang.view_details') }}" class='btn btn-link'
                                data-toggle="modal" data-target="#bookingAdDetailsModal{{ $booking_ad->id }}">
                                <i class="fas fa-info-circle text-info text-md"></i>
                            </a>
                            @include('booking_ads.modal')
                            @if ($booking_ad->status == 0)
                                <a href="{{ route('booking.ads.approve', $booking_ad->id) }}"
                                    title="{{ trans('lang.approve') }}" class='btn btn-link'
                                    onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-check-circle text-success text-md"></i>
                                </a>

                                <a href="{{ route('booking.ads.reject', $booking_ad->id) }}"
                                    title="{{ trans('lang.reject') }}" class='btn btn-link' data-toggle="modal"
                                    data-target="#rejectModal{{ $booking_ad->id }}">
                                    <i class="fas fa-times-circle text-danger text-md"></i>
                                </a>
                                @include('booking_ads.reject_modal')
                            @endif
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{ $dataTable->links() }}
