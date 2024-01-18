<!-- Id Field -->
<div class="form-group row col-6">
    {!! Form::label('id', 'Id:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $user->id !!}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row col-6">
    {!! Form::label('full_name', 'Name:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $user->full_name !!}</p>
    </div>
</div>

<!-- Email Field -->
<div class="form-group row col-6">
    {!! Form::label('email', 'Email:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $user->email !!}</p>
    </div>
</div>

<!-- Image Field -->
<div class="form-group row col-6">
    {!! Form::label('image', 'Image:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <img class="col-md-3 control-label text-md-right mx-1" style="height:50px" alt="{{ trans('lang.category_image') }}"
                src="{{ asset('storage/images/users/' . $user->info()?->image) }}">
    </div>
</div>

<!-- Password Field -->
{{-- <div class="form-group row col-6">
    {!! Form::label('password', 'Password:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $user->password !!}</p>
    </div>
</div> --}}

<!-- Api Token Field -->
{{-- <div class="form-group row col-6">
    {!! Form::label('api_token', 'Api Token:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $user->api_token !!}</p>
    </div>
</div> --}}

<!-- Store Id Field -->
{{-- <div class="form-group row col-6">
    {!! Form::label('store_id', 'Store Id:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $user->store_id !!}</p>
    </div>
</div> --}}

<!-- Role Id Field -->
<div class="form-group row col-6">
    {!! Form::label('role_id', 'Role Id:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $user->role_id !!}</p>
    </div>
</div>

{{-- <!-- Remember Token Field -->
<div class="form-group row col-6">
    {!! Form::label('remember_token', 'Remember Token:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $user->remember_token !!}</p>
    </div>
</div> --}}

<!-- Created At Field -->
<div class="form-group row col-6">
    {!! Form::label('created_at', 'Created At:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $user->created_at !!}</p>
    </div>
</div>

<!-- Updated At Field -->
<div class="form-group row col-6">
    {!! Form::label('updated_at', 'Updated At:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $user->updated_at !!}</p>
    </div>
</div>

