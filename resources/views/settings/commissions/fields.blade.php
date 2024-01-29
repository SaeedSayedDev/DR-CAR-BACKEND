<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Commission Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('commission', trans("lang.e_provider_type_commission"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::number('commission', null,  ['class' => 'form-control','step'=>'0.01', 'min'=>'0', 'placeholder'=>  trans("lang.tax_name_placeholder")]) !!}
        </div>
    </div>
</div>
<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Type Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('type', trans("lang.tax_type"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::select('type', ['1' => trans('lang.tax_percent'), '0' => trans('lang.tax_fixed')], null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted"></div>
        </div>
    </div>

    <!-- Commission From Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('commission_from', trans("lang.by"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::select('commission_from', ['1' => trans('lang.garage'), '0' => trans('lang.user')], null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted"></div>
        </div>
    </div>
</div>
<!-- Submit Field -->
<div class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
    <button type="submit" class="btn bg-primary mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
        <i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.e_provider_type_commission')}}</button>
    <a href="{!! route('commissions.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
