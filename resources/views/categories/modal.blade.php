<!-- Modal -->
<div class="modal fade" id="categoryDetailsModal{{ $category->id }}" tabindex="-1" role="dialog"
    aria-labelledby="categoryDetailsModalLabel{{ $category->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryDetailsModalLabel{{ $category->id }}">
                    {{ $category->name }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <img class="rounded image-modal" alt="{{ trans('lang.category_image') }}"
                            src="{{ $category->media[0]->image ?? $noneImage }}">
                    </div>
                    <div class="col-md-7">
                        <p><strong>{{ trans('lang.category_description') }}:</strong> {{ $category->desc }}</p>
                        <p>
                            <strong>{{ trans('lang.item_plural') }}:</strong>
                            @if ($category->items_count)
                                <a href="{{ route('items.category', $category->id)}}">{{ $category->items_count }}</a>
                            @else
                                {{ $category->items_count }}
                            @endif
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    {{ trans('lang.close') }}
                </button>
            </div>
        </div>
    </div>
</div>
