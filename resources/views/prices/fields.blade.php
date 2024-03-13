@include('partials.request_errors_first')

<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Type Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('type', trans("lang.tax_type"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('type', null, ['class' => 'form-control', 'placeholder' => trans("lang.tax_type_placeholder"), 'readonly' => 'readonly']) !!}
        </div>
    </div>

    <!-- Per Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('per', trans("lang.per"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('per', null,  ['class' => 'form-control','placeholder'=>  trans("lang.per"), 'readonly' => 'readonly']) !!}
        </div>
    </div>
</div>
<div class="d-flex flex-column col-sm-12 col-md-6">
<!-- Amount Field -->
<div class="form-group align-items-baseline d-flex flex-column flex-md-row">
    {!! Form::label('amount', trans("lang.payment_amount"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        {!! Form::number('amount', null, ['class' => 'form-control', 'placeholder' => trans("lang.payment_amount_placeholder"), 'min' => '0', 'step' => '0.01']) !!}
    </div>
</div>
</div>

<!-- Submit Field -->
<div class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
    <button type="submit" class="btn bg-primary mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
        <i class="fas fa-save"></i> {{trans('lang.save')}} {{trans('lang.price')}}</button>
    <a href="{!! route('prices.index') !!}" class="btn btn-default"><i class="fas fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
