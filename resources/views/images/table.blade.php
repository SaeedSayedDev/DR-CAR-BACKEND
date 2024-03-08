@push('css_lib')
    @include('layouts.datatables_css')
@endpush

{{-- {!! $dataTable->table(['width' => '100%']) !!} --}}

@push('scripts_lib')
    @include('layouts.datatables_js')
    {{-- {!! $dataTable->scripts() !!} --}}
@endpush

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>{{ trans('lang.image') }}</th>
                <th>{{ trans('lang.tax_type') }}</th>
                <th>{{ trans('lang.category_updated_at') }}</th>
                <th class="w-30 text-center">{{ trans('lang.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($dataTable as $image)
                <tr>
                    <td>
                        <img class="rounded image-image" alt="{{ trans('lang.category_image') }}"
                            src="{{ $image->image }}">
                    </td>
                    <td>{{ $image->type }}</td>
                    <td>{{ $image->updated_at->diffForHumans() }}</td>
                    <td>
                        <form method="POST" action="{{ route('images.update', $image->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="image" name="image"
                                        onchange="updateFileName(this)">
                                    <label class="custom-file-label"
                                        for="image">{{ trans('lang.gallery_image_help') }}</label>
                                </div>
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">{{ trans('lang.save') }}</button>
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    function updateFileName(input) {
        var fileName = input.files[0].name;
        var label = input.nextElementSibling;
        label.innerText = fileName;
    }
</script>
