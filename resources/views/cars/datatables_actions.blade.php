<div class='btn-group btn-group-sm'>
    @can('cars.show')
        <a data-toggle="tooltip" data-placement="left" title="{{trans('lang.view_details')}}" href="{{ route('cars.show', $id) }}" class='btn btn-link'>
            <i class="fas fa-eye"></i> </a> @endcan

    @can('cars.edit')
        <a data-toggle="tooltip" data-placement="left" title="{{trans('lang.car_edit')}}" href="{{ route('cars.edit', $id) }}" class='btn btn-link'>
            <i class="fas fa-edit"></i> </a> @endcan

    @can('cars.destroy') {!! Form::open(['route' => ['cars.destroy', $id], 'method' => 'delete']) !!} {!! Form::button('<i class="fas fa-trash"></i>', [ 'type' => 'submit', 'class' => 'btn btn-link text-danger', 'onclick' => "return confirm('Are you sure?')" ]) !!} {!! Form::close() !!} @endcan
</div>
