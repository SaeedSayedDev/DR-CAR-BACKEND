@include('partials.request_errors_first')

<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Name Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('name', trans("lang.tax_name"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.tax_name_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.tax_name_help") }}
            </div>
        </div>
    </div>
</div>

<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Image Field -->
    <div class="form-group align-items-start d-flex flex-column flex-md-row">
        {!! Form::label('image', trans('lang.category_image'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::file('image', ['class' => 'form-control-file']) !!}
            <div class="form-text text-muted w-50">
                {{ trans('lang.category_image_help') }}
            </div>
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
    <button type="submit" class="btn bg-primary mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
        <i class="fas fa-save"></i> {{trans('lang.save')}} {{trans('lang.car')}}</button>
    <a href="{!! route('cars.index') !!}" class="btn btn-default"><i class="fas fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
