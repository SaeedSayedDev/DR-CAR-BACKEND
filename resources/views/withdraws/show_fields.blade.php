<!-- Id Field -->
<div class="form-group row col-6">
    {!! Form::label('id', 'Id:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $withdraw->id !!}</p>
    </div>
</div>

<div class="form-group row col-6">
    {!! Form::label('full_name', trans('lang.user_name'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $withdraw->user->full_name !!}</p>
    </div>
</div>

<div class="form-group row col-6">
    {!! Form::label('full_name', trans('lang.payment_amount'), [
        'class' => 'col-md-3 control-label text-md-right mx-1',
    ]) !!}
    <div class="col-md-9">
        <p>{!! $withdraw->amount !!}</p>
    </div>
</div>

<div class="form-group row col-6">
    {!! Form::label('full_name', trans('lang.payment_status'), [
        'class' => 'col-md-3 control-label text-md-right mx-1',
    ]) !!}
    <div class="col-md-9">
        <p>{!! $withdraw->status !!}</p>
    </div>
</div>

<div class="form-group row col-6">
    {!! Form::label('full_name', trans('lang.tax_type'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $withdraw->type !!}</p>
    </div>
</div>

<!-- Updated At Field -->
<div class="form-group row col-6">
    {!! Form::label('updated_at', trans('lang.user_updated_at'), [
        'class' => 'col-md-3 control-label text-md-right mx-1',
    ]) !!}
    <div class="col-md-9">
        <p>{!! $withdraw->updated_at !!}</p>
    </div>
</div>

@if ($withdraw->type == 'paypal')
    <div class="form-group row col-6">
        {!! Form::label('full_name', trans('lang.paypal_email'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            <p>{!! $withdraw->paypal_email !!}</p>
        </div>
    </div>

    <div class="form-group row col-6">
        {!! Form::label('full_name', trans('lang.paypal_name'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            <p>{!! $withdraw->full_name !!}</p>
        </div>
    </div>
@else
    <div class="form-group row col-6">
        {!! Form::label('full_name', trans('lang.account_number'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            <p>{!! $withdraw->account_number !!}</p>
        </div>
    </div>

    <div class="form-group row col-6">
        {!! Form::label('full_name', trans('lang.iban'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <p>{!! $withdraw->iban !!}</p>
        </div>
    </div>

    <div class="form-group row col-6">
        {!! Form::label('full_name', trans('lang.bank_name'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <p>{!! $withdraw->bank_name !!}</p>
        </div>
    </div>
@endif
