@include('partials.form_errors')

{{-- @if ($customFields)
    <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif --}}
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

    <!-- Name Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('name', trans('lang.e_provider_name'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('name', null, [
                'class' => 'form-control',
                'placeholder' => trans('lang.e_provider_name_placeholder'),
            ]) !!}
            <div class="form-text text-muted">
                {{ trans('lang.e_provider_name_help') }}
            </div>
        </div>
    </div>

    <!-- E Provider Type Id Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('garage_type', trans('lang.e_provider_e_provider_type_id'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            {!! Form::select('garage_type', $eProviderType, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans('lang.e_provider_e_provider_type_id_help') }}</div>
        </div>
    </div>

    <!-- E Provider User Id Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('garage_id', trans('lang.user'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            {!! Form::select('garage_id', $eProviderUser, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans('lang.user') }}</div>
        </div>
    </div>
</div>
<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Addresses Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('address_id', trans('lang.e_provider_addresses'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            {!! Form::select('address_id', $eProviderAddress, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">
                {{ trans('lang.e_provider_addresses_help') }}
                @can('addresses.create')
                    <a href="{{ route('addresses.create') }}"
                        class="text-success float-right">{{ __('lang.address_create') }}</a>
                @endcan
            </div>
        </div>
    </div>

    <!-- Taxes Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('tax_id', trans('lang.e_provider_taxes'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            {!! Form::select('tax_id', $eProviderTax, null, ['class' => 'select2 form-control']) !!}
            <div class="form-text text-muted">{{ trans('lang.e_provider_taxes_help') }}</div>
        </div>
    </div>

    <!-- Availability Range Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
        {!! Form::label('availability_range', trans('lang.e_provider_availability_range'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::number('availability_range', null, [
                    'class' => 'form-control',
                    'step' => 'any',
                    'min' => '0',
                    'placeholder' => trans('lang.e_provider_availability_range_placeholder'),
                ]) !!}
                <div class="input-group-append">
                    <div class="input-group-text text-bold px-3">
                        {{ trans('lang.app_setting_mi') }}</div>
                </div>
            </div>
            <div class="form-text text-muted">
                {{ trans('lang.e_provider_availability_range_help') }}
            </div>
        </div>
    </div>

        <!-- Check Service Price Field -->
        <div class="form-group align-items-baseline d-flex flex-column flex-md-row ">
        {!! Form::label('checkServicePrice', trans('lang.check_service_price'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            <div class="input-group">
                {!! Form::number('checkServicePrice', null, [
                    'class' => 'form-control',
                    'step' => 'any',
                    'min' => '0',
                ]) !!}
            </div>
        </div>
    </div>
</div>
<!-- Submit Field -->
<div
    class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
    {{-- @role('admin')
    <div class="d-flex flex-row justify-content-between align-items-center">
        {!! Form::label('accepted', trans("lang.e_provider_accepted"),['class' => 'control-label my-0 mx-3']) !!} {!! Form::hidden('accepted', 0, ['id'=>"hidden_accepted"]) !!}
        <span class="icheck-primary">
            {!! Form::checkbox('accepted', 1, null) !!} <label for="accepted"></label> </span>
    </div>
    @endrole
    <div class="d-flex flex-row justify-content-between align-items-center">
        {!! Form::label('available', trans("lang.e_provider_available"),['class' => 'control-label my-0 mx-3']) !!} {!! Form::hidden('available', 0, ['id'=>"hidden_available"]) !!}
        <span class="icheck-primary">
            {!! Form::checkbox('available', 1, null) !!} <label for="available"></label> </span>
    </div>
    <div class="d-flex flex-row justify-content-between align-items-center">
        {!! Form::label('featured', trans("lang.e_provider_featured"),['class' => 'control-label my-0 mx-3']) !!} {!! Form::hidden('featured', 0, ['id'=>"hidden_featured"]) !!}
        <span class="icheck-primary">
            {!! Form::checkbox('featured', 1, null) !!} <label for="featured"></label> </span>
    </div> --}}
    <button type="submit" class="btn bg-primary mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
        <i class="fa fa-save"></i> {{ trans('lang.save') }} {{ trans('lang.e_provider') }}</button>
    <a href="{!! route('eProviders.index') !!}" class="btn btn-default"><i class="fa fa-undo"></i>
        {{ trans('lang.cancel') }}</a>
</div>
