@include('partials.request_errors_first')

{{-- @if ($customFields)
    <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif --}}
<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Name Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('name', trans('lang.category_name'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('name', null, [
                'class' => 'form-control',
                'placeholder' => trans('lang.category_name_placeholder'),
            ]) !!}
            <div class="form-text text-muted">
                {{ trans('lang.category_name_help') }}
            </div>
        </div>
    </div>

    <!-- Description Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('desc', trans('lang.category_description'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            {!! Form::textarea('desc', null, [
                'class' => 'form-control',
                'placeholder' => trans('lang.category_description_placeholder'),
            ]) !!}
            <div class="form-text text-muted">{{ trans('lang.category_description_help') }}</div>
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

    <!-- Parent Id Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('category_id', trans('lang.category'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            {!! Form::select('category_id', $form, null, [
                'data-empty' => trans('lang.category_parent_id_placeholder'),
                'class' => 'select2 not-required form-control',
            ]) !!}
            <div class="form-text text-muted">{{ trans('lang.category_parent_id_help') }}</div>
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
    {{-- <div class="d-flex flex-row justify-content-between align-items-center">
        {!! Form::label('featured', trans('lang.category_featured_help'), ['class' => 'control-label my-0 mx-3'], false) !!} {!! Form::hidden('featured', 0, ['id' => 'hidden_featured']) !!}
        <span class="icheck-primary">
            {!! Form::checkbox('featured', 1, null) !!} <label for="featured"></label> </span>
    </div> --}}
    <button type="submit" class="btn bg-primary mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
        <i class="fa fa-save"></i> {{ trans('lang.save') }} {{ trans('lang.category') }}
    </button>
    <a href="{!! route('items.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i> {{ trans('lang.cancel') }}</a>
</div>
