<div class="d-flex flex-column col-sm-12 col-md-12">
    @if ($errors->any())
        <div class="alert alert-danger">
            {{ $errors->first() }}
        </div>
    @endif
</div>