<!-- Id Field -->
<div class="form-group row col-6">
    {!! Form::label('id', 'Id:', ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $item->id !!}</p>
    </div>
</div>

<!-- Name Field -->
<div class="form-group row col-6">
    {!! Form::label('name', trans('lang.category_name'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $item->name !!}</p>
    </div>
</div>

<!-- Description Field -->
<div class="form-group row col-6">
    {!! Form::label('description', trans('lang.category_description'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $item->description !!}</p>
    </div>
</div>

<!-- Image Field -->
<div class="form-group row col-6">
    {!! Form::label('image', trans('lang.category_image'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <img class="col-md-3 control-label text-md-right mx-1" style="height:50px" alt="{{ trans('lang.category_image') }}"
                src="{{ asset('storage/images/admin/items/' . $item->media()?->first()?->image) }}">
    </div>
</div>

<!-- Parent Id Field -->
<div class="form-group row col-6">
    {!! Form::label('parent_id', trans('lang.category'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $item->category->id !!}</p>
    </div>
</div>

<!-- Updated At Field -->
<div class="form-group row col-6">
    {!! Form::label('updated_at', trans('lang.category_updated_at'), ['class' => 'col-md-3 control-label text-md-right mx-1']) !!}
    <div class="col-md-9">
        <p>{!! $item->updated_at !!}</p>
    </div>
</div>

