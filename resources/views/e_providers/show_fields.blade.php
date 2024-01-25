<!-- Id Field -->
<div class="form-group row col-6">
    {!! Form::label('id', 'Id:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->id !!}</p>
    </div>
</div>

<!-- Image Field -->
<div class="form-group row col-6">
    {!! Form::label('image', 'Image:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <img class="col-md-3 control-label text-md-right mx-1" style="height:50px" alt="{{ trans('lang.category_image') }}"
                src="{{ asset('storage/images/providers/' . $eProvider->media()?->first()?->image) }}">
    </div>
</div>

<!-- Name Field -->
<div class="form-group row col-6">
    {!! Form::label('name', 'Name:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->name !!}</p>
    </div>
</div>

<!-- E Provider Type Id Field -->
<div class="form-group row col-6">
    {!! Form::label('e_provider_type_id', 'E Provider Type Id:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->garage_type == 0 ? trans('lang.private') : trans('lang.company') !!}</p>
    </div>
</div>

<!-- Users Field -->
<div class="form-group row col-6">
    {!! Form::label('users', 'Users:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->user->full_name !!}</p>
    </div>
</div>

<!-- Phone Number Field -->
<div class="form-group row col-6">
    {!! Form::label('phone_number', 'Phone Number:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->user->garage_information->phone_number !!}</p>
    </div>
</div>

<!-- Addresses Field -->
<div class="form-group row col-6">
    {!! Form::label('addresses', 'Addresses:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->address->address !!}</p>
    </div>
</div>

<!-- Availability Range Field -->
<div class="form-group row col-6">
    {!! Form::label('availability_range', 'Availability Range:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->availability_range !!}</p>
    </div>
</div>

<!-- Taxes Field -->
<div class="form-group row col-6">
    {!! Form::label('taxes', 'Taxes:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $eProvider->taxe->value !!}</p>
    </div>
</div>

