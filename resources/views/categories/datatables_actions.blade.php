<div class='btn-group btn-group-sm'>
        <a data-toggle="tooltip" data-placement="left" title="{{trans('lang.view_details')}}" href="{{ route('categories.show', $id) }}" class='btn btn-link'>
            <i class="fas fa-eye"></i> </a>

        <a data-toggle="tooltip" data-placement="left" title="{{trans('lang.category_edit')}}" href="{{ route('categories.edit', $id) }}" class='btn btn-link'>
            <i class="fas fa-edit"></i> </a>

     {!! Form::open(['route' => ['categories.destroy', $id], 'method' => 'delete']) !!} {!! Form::button('<i class="fas fa-trash"></i>', [ 'type' => 'submit', 'class' => 'btn btn-link text-danger', 'onclick' => "return confirm('Are you sure?')" ]) !!} {!! Form::close() !!}
</div>
