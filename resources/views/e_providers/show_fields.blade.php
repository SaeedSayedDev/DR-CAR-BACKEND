<!-- Id Field -->
<div class="form-group row col-6">
    {!! Form::label('id', 'Id:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->id !!}</p>
    </div>
</div>

<!-- Image Field -->
<div class="form-group row col-6">
    {!! Form::label('image', trans('lang.e_provider_image'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <img class="col-md-3 control-label text-md-right mx-1" style="height:50px" alt="{{ trans('lang.category_image') }}"
                src="{{ asset('storage/images/providers/' . $eProvider->media()?->first()?->image) }}">
    </div>
</div>

<!-- Name Field -->
<div class="form-group row col-6">
    {!! Form::label('name', trans('lang.e_provider_name'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->name !!}</p>
    </div>
</div>

<!-- E Provider Type Id Field -->
<div class="form-group row col-6">
    {!! Form::label('e_provider_type_id', trans('lang.e_provider_e_provider_type_id'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->garage_type == 0 ? trans('lang.private') : trans('lang.company') !!}</p>
    </div>
</div>

<!-- Users Field -->
<div class="form-group row col-6">
    {!! Form::label('users', trans('lang.e_provider_users'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->user->full_name !!}</p>
    </div>
</div>

<!-- Phone Number Field -->
<div class="form-group row col-6">
    {!! Form::label('phone_number', trans('lang.e_provider_phone_number'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->user->garage_information->phone_number !!}</p>
    </div>
</div>

<!-- Addresses Field -->
<div class="form-group row col-6">
    {!! Form::label('addresses', trans('lang.e_provider_addresses'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->address->address !!}</p>
    </div>
</div>

<!-- Availability Range Field -->
<div class="form-group row col-6">
    {!! Form::label('availability_range', trans('lang.e_provider_availability_range'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->availability_range !!}</p>
    </div>
</div>

<!-- Taxes Field -->
<div class="form-group row col-6">
    {!! Form::label('taxes', trans('lang.e_provider_taxes'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->taxe->value !!}</p>
    </div>
</div>

