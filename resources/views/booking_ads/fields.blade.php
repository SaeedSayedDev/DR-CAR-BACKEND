{{-- @if ($customFields)
    <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif --}}
@include('partials.request_errors')
<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Code Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('coupon', trans('lang.coupon_code'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            @if (isset($coupon['code']))
                <p>{!! $coupon->code !!}</p>
            @else
                {!! Form::text('coupon', null, [
                    'class' => 'form-control',
                    'placeholder' => trans('lang.coupon_code_placeholder'),
                ]) !!}
                <div class="form-text text-muted">
                    {{ trans('lang.coupon_code_help') }}
                </div>
            @endif
        </div>
    </div>

    <!-- Discount Type Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('coupon_unit', trans('lang.coupon_discount_type'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            {!! Form::select('coupon_unit', ['1' => trans('lang.coupon_percent'), '0' => trans('lang.coupon_fixed')], null, [
                'class' => 'select2 form-control',
            ]) !!}
            <div class="form-text text-muted">{{ trans('lang.coupon_discount_type_help') }}</div>
        </div>
    </div>

    <!-- Discount Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('coupon_price', trans('lang.coupon_discount'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            {!! Form::number('coupon_price', null, [
                'class' => 'form-control',
                'placeholder' => trans('lang.coupon_discount_placeholder'),
                'step' => 'any',
                'min' => '0',
            ]) !!}
            <div class="form-text text-muted">
                {!! trans('lang.coupon_discount_help') !!}
            </div>
        </div>
    </div>
</div>

<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- EProvider Id Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('provider_id', trans('lang.coupon_e_provider_id'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            {!! Form::select('provider_id', $eProvider, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans('lang.coupon_e_provider_id_help') }}</div>
        </div>
    </div>

<!-- Start Date Field -->
<div class="form-group align-items-baseline d-flex flex-column flex-md-row">
    {!! Form::label('start_date', trans('lang.booking_start_at'), [
        'class' => 'col-md-3 control-label text-md-right mx-1',
    ]) !!}
    <div class="col-md-9">
        {!! Form::input(
            'datetime-local', 'start_date', null,
            ['class' => 'form-control', 'placeholder' => trans('lang.start_date_placeholder')],
        ) !!}
        <div class="form-text text-muted">
            {{ trans('lang.booking_start_at_help') }}
        </div>
    </div>
</div>

<!-- End Date Field -->
<div class="form-group align-items-baseline d-flex flex-column flex-md-row">
    {!! Form::label('end_date', trans('lang.coupon_expires_at'), [
        'class' => 'col-md-3 control-label text-md-right mx-1',
    ]) !!}
    <div class="col-md-9">
        {!! Form::input(
            'datetime-local', 'end_date', null,
            ['class' => 'form-control', 'placeholder' => trans('lang.end_date_placeholder')],
        ) !!}
        <div class="form-text text-muted">
            {{ trans('lang.coupon_expires_at_help') }}
        </div>
    </div>
</div>
</div>

{{-- @if ($customFields)
    <div class="clearfix"></div>
    <div class="col-12 custom-field-container">
        <h5 class="col-12 pb-4">{!! trans('lang.custom_field_plural') !!}</h5>
        {!! $customFields !!}
    </div>
@endif --}}

<!-- Submit Field -->
<div
    class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
    <button type="submit" class="btn bg-primary mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
        <i class="fas fa-save"></i> {{ trans('lang.save') }} {{ trans('lang.coupon') }}</button>
    <a href="{!! route('coupons.index') !!}" class="btn btn-default"><i class="fas fa-undo"></i>
        {{ trans('lang.cancel') }}</a>
</div>
