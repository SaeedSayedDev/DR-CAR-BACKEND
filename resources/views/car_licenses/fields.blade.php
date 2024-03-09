{{-- @if($customFields)
    <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif --}}

<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Name Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('name', trans("lang.e_service_name"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('name', null,  ['class' => 'form-control','placeholder'=>  trans("lang.e_service_name_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.e_service_name_help") }}
            </div>
        </div>
    </div>

    <!-- Categories Field -->
    {{-- <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
        {!! Form::label('categories[]', trans("lang.e_service_categories"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::select('categories[]', $category, $categoriesSelected, ['class' => 'select2 form-control not-required' , 'data-empty'=>trans('lang.e_service_categories_placeholder'),'multiple'=>'multiple']) !!}
            <div class="form-text text-muted">{{ trans("lang.e_service_categories_help") }}</div>
        </div>
    </div> --}}

    <!-- Price Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
        {!! Form::label('price', trans("lang.e_service_price"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::number('price', null, ['class' => 'form-control','step'=>'any', 'min'=>'0', 'placeholder'=> trans("lang.e_service_price_placeholder")]) !!}
                <div class="input-group-append">
                    <div class="input-group-text text-bold px-3">$</div>
                </div>
            </div>
            <div class="form-text text-muted">
                {{ trans("lang.e_service_price_help") }}
            </div>
        </div>
    </div>

    <!-- Discount Price Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
        {!! Form::label('discount_price', trans("lang.e_service_discount_price"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::number('discount_price', null, ['class' => 'form-control','step'=>'any', 'min'=>'0', 'placeholder'=> trans("lang.e_service_discount_price_placeholder")]) !!}
                <div class="input-group-append">
                    <div class="input-group-text text-bold px-3">$</div>
                </div>
            </div>
            <div class="form-text text-muted">
                {{ trans("lang.e_service_discount_price_help") }}
            </div>
        </div>
    </div>

    <!-- Price Unit Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
        {!! Form::label('price_unit', trans("lang.e_service_price_unit"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::select('price_unit', ['0' => trans('lang.e_service_price_unit_hourly'),'1'=> trans('lang.e_service_price_unit_fixed')], null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.e_service_price_unit_help") }}</div>
        </div>
    </div>

    <!-- Quantity Unit Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('quantity_unit', trans("lang.e_service_quantity_unit"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('quantity_unit', null,  ['class' => 'form-control','placeholder'=>  trans("lang.e_service_quantity_unit_placeholder")]) !!}
            <div class="form-text text-muted">
                {{ trans("lang.e_service_quantity_unit_help") }}
            </div>
        </div>
    </div>

    <!-- Duration Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
        {!! Form::label('duration', trans("lang.e_service_duration"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            <div class="input-group timepicker duration" data-target-input="nearest">
                {!! Form::text('duration', null,  ['class' => 'form-control datetimepicker-input','placeholder'=>  trans("lang.e_service_duration_placeholder"), 'data-target'=>'.timepicker.duration','data-toggle'=>'datetimepicker','autocomplete'=>'off']) !!}
                <div id="widgetParentId"></div>
                <div class="input-group-append" data-target=".timepicker.duration" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fas fa-business-time"></i></div>
                </div>
            </div>
            <div class="form-text text-muted">
                {{ trans("lang.e_service_duration_help") }}
            </div>
        </div>
    </div>

    <!-- E Provider Id Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
        {!! Form::label('provider_id', trans("lang.e_service_e_provider_id"),['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::select('provider_id', $eProvider, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans("lang.e_service_e_provider_id_help") }}</div>
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

<!-- Description Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
        {!! Form::label('desc', trans("lang.e_service_description"), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::textarea('desc', null, ['class' => 'form-control','placeholder'=>
             trans("lang.e_service_description_placeholder")  ]) !!}
            <div class="form-text text-muted">{{ trans("lang.e_service_description_help") }}</div>
        </div>
    </div>
</div>

{{-- @if($customFields)
    <div class="clearfix"></div>
    <div class="col-12 custom-field-container">
        <h5 class="col-12 pb-4">{!! trans('lang.custom_field_plural') !!}</h5>
        {!! $customFields !!}
    </div>
@endif --}}

<!-- Submit Field -->
<div class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
    <div class="d-flex flex-row justify-content-between align-items-center">
        {!! Form::label('featured', trans("lang.e_service_featured"),['class' => 'control-label my-0 mx-3']) !!} {!! Form::hidden('featured', 0, ['id'=>"hidden_featured"]) !!}
        <span class="icheck-primary">
            {!! Form::checkbox('featured', 1, null) !!} <label for="featured"></label> </span>
    </div>
    <div class="d-flex flex-row justify-content-between align-items-center">
        {!!  Form::label('enable_booking', trans("lang.e_service_enable_booking"),['class' => 'control-label my-0 mx-3'], false)  !!} {!! Form::hidden('enable_booking', 0, ['id'=>"hidden_enable_booking"]) !!}
        <span class="icheck-primary">
            {!! Form::checkbox('enable_booking', 1, null) !!} <label for="enable_booking"></label> </span>
    </div>
    <div class="d-flex flex-row justify-content-between align-items-center">
        {!! Form::label('available', trans("lang.e_service_available"),['class' => 'control-label my-0 mx-3']) !!} {!! Form::hidden('available', 0, ['id'=>"hidden_available"]) !!}
        <span class="icheck-primary">
            {!! Form::checkbox('available', 1, null) !!} <label for="available"></label> </span>
    </div>
    <button type="submit" class="btn bg-primary mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
        <i class="fa fa-save"></i> {{trans('lang.save')}} {{trans('lang.e_service')}}</button>
    <a href="{!! route('eServices.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{trans('lang.cancel')}}</a>
</div>
