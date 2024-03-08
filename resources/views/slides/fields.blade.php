@include('partials.request_errors')
<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Order Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('order', trans("lang.slide_order"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::number('order', null,  ['class' => 'form-control','placeholder'=>  trans("lang.slide_order_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.slide_order_help") }}
            </div>
        </div>
    </div>
    <!-- Text Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('text', trans("lang.slide_text"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('text', null,  ['class' => 'form-control','placeholder'=>  trans("lang.slide_text_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.slide_text_help") }}
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

    <!-- E Service Id Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('service_id', trans("lang.slide_e_service_id"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::select('service_id', $eService, null, ['data-empty'=>trans("lang.slide_e_service_id_placeholder"), 'class' => 'select2 not-required form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.slide_e_service_id_help") }}</div>
        </div>
    </div>
</div>

<!-- Submit Field -->
<div class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
    <button type="submit" class="btn bg-primary mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
        <i class="fas fa-save"></i> {{trans('lang.save')}} {{trans('lang.slide')}}</button>
    <a href="{!! route('slides.index') !!}" class="btn btn-default"><i class="fas fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
