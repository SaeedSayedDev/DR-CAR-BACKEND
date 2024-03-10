<div class="card shadow-sm">
    <div class="card-header no-border">
        <h3 class="card-title">{{ trans('lang.e_provider_plural') }}</h3>
        <div class="card-tools">
            <a href="{{ route('eProviders.index') }}" class="btn btn-tool btn-sm">
                <i class="fas fa-bars"></i>
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-valign-middle">
            <thead>
                <tr>
                    <th>{{ trans('lang.e_provider') }}</th>
                    <th>{{ trans('lang.garage') }}</th>
                    <th>{{ trans('lang.e_service') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($eProviders as $eProvider)
                    <tr>
                        <td>
                            <a href="{{ route('eProviders.provider', $eProvider->id) }}">
                                {{ $eProvider->name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('users.user', $eProvider->user->id) }}">
                                {{ $eProvider->user->full_name }}
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('eServices.service', $eProvider->checkService->id) }}">
                                {{ $eProvider->checkService->name }}
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
