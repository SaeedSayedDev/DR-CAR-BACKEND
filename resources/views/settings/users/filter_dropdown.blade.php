<li class="nav-item dropdown keepopen">
    <div class="dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" id="filterDropdown"
            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-filter"></i> {{ trans('lang.filter') }}
        </a>
        <div class="dropdown-menu" aria-labelledby="filterDropdown">
            <form action="{{ route('users.index') }}" method="GET" class="px-4 py-3">
                @foreach ($filters as $filterKey => $filterLabel)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="filters[]"
                            value="{{ $filterKey }}" id="{{ $filterKey }}">
                        <label class="form-check-label" for="{{ $filterKey }}">
                            {{ $filterLabel }}
                        </label>
                    </div>
                @endforeach
                <button type="submit" class="btn btn-primary mt-3">
                    {{ trans('lang.filter_apply') }}
                </button>
            </form>
        </div>
    </div>
</li>
