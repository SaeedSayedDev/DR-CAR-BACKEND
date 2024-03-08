@include('partials.request_errors_first')

{{-- @if ($customFields)
    <h5 class="col-12 pb-4">{!! trans('lang.main_fields') !!}</h5>
@endif --}}

<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- Name Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('full_name', trans('lang.user_name'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('full_name', null, [
                'class' => 'form-control',
                'placeholder' => trans('lang.user_name_placeholder'),
            ]) !!}
            <div class="form-text text-muted">
                {{ trans('lang.user_name_help') }}
            </div>
        </div>
    </div>

    <!-- Email Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('email', trans('lang.user_email'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::text('email', null, [
                'class' => 'form-control',
                'placeholder' => trans('lang.user_email_placeholder'),
            ]) !!}
            <div class="form-text text-muted">
                {{ trans('lang.user_email_help') }}
            </div>
        </div>
    </div>

    <!-- Phone Number Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('phone_number', trans('lang.user_phone_number'), [
            'class' => 'col-md-3 control-label text-md-right mx-1',
        ]) !!}
        <div class="col-md-9">
            {!! Form::text('phone_number', null, [
                'class' => 'form-control',
                'placeholder' => trans('lang.user_phone_number_placeholder'),
            ]) !!}
            <div class="form-text text-muted">
                {{ trans('lang.user_phone_number_help') }}
            </div>
        </div>
    </div>

    <!-- Password Field -->
    @if (Route::is('users.create'))
        <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
            {!! Form::label('password', trans('lang.user_password'), [
                'class' => 'col-md-3 control-label text-md-right mx-1',
            ]) !!}
            <div class="col-md-9">
                {!! Form::password('password', [
                    'class' => 'form-control',
                    'placeholder' => trans('lang.user_password_placeholder'),
                ]) !!}
                <div class="form-text text-muted">
                    {{ trans('lang.user_password_help') }}
                </div>
            </div>
        </div>
    @endif
</div>
<div class="d-flex flex-column col-sm-12 col-md-6">
    <!-- $FIELD_NAME_TITLE$ Field -->
    <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
        {!! Form::label('image', trans('lang.user_avatar'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
        <div class="col-md-9">
            {!! Form::file('image', ['class' => 'form-control-file']) !!}
            <div class="form-text text-muted w-50">
                {{ trans('lang.user_avatar_help') }}
            </div>
        </div>
    </div>

    <!-- Roles Field -->
    @if (Route::is('users.create'))
        <div class="form-group align-items-baseline d-flex flex-column flex-md-row">
            {!! Form::label('role_id', trans('lang.user_role_id'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
            <div class="col-md-9">
                {!! Form::select('role_id', $roles, null, ['class' => 'select2 form-control']) !!}
                <div class="form-text text-muted">{{ trans('lang.user_role_id_help') }}</div>
            </div>
        </div>
    @endif
</div>

<!-- Short Biography Field -->
<div class="form-group align-items-baseline d-flex flex-column flex-md-row col-sm-12 col-md-6">
    {!! Form::label('short_biography', trans('lang.user_bio'), [
        'class' => 'col-md-3 control-label text-md-right mx-1',
    ]) !!}
    <div class="col-md-9">
        {!! Form::textarea('short_biography', null, [
            'class' => 'form-control',
            'placeholder' => trans('lang.e_provider_description_placeholder'),
        ]) !!}
        <div class="form-text text-muted">{{ trans('lang.e_provider_description_help') }}</div>
    </div>
</div>

<!-- Addresses Field -->
<div class="form-group align-items-baseline d-flex flex-column flex-md-row col-sm-12 col-md-6">
    {!! Form::label('address', trans('lang.e_provider_addresses'), [
        'class' => 'col-md-3 control-label text-md-right mx-1',
    ]) !!}
    <div class="col-md-9">
        {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => trans('lang.address')]) !!}
        <div class="form-text text-muted">
            {{ trans('lang.e_provider_addresses_help') }}
            @can('addresses.create')
                <a href="{{ route('addresses.create') }}"
                    class="text-success float-right">{{ __('lang.address_create') }}</a>
            @endcan
        </div>
    </div>
</div>

{{-- @if ($customFields) --}}
{{-- TODO generate custom field --}}
{{-- <div class="clearfix"></div>
    <div class="col-12 custom-field-container">
        <h5 class="col-12 pb-4">{!! trans('lang.custom_field_plural') !!}</h5>
        {!! $customFields !!}
    </div>
@endif --}}
<!-- Submit Field -->
<div
    class="form-group col-12 d-flex flex-column flex-md-row justify-content-md-end justify-content-sm-center border-top pt-4">
    <button type="submit" class="btn bg-primary mx-md-3 my-lg-0 my-xl-0 my-md-0 my-2">
        <i class="fas fa-save"></i> {{ trans('lang.save') }} {{ trans('lang.user') }}</button>
    <a href="{!! route('users.index') !!}" class="btn btn-default"><i class="fas fa-undo"></i>
        {{ trans('lang.cancel') }}</a>
</div>
