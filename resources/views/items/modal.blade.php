<!-- Modal -->
<div class="modal fade" id="itemDetailsModal{{ $item->id }}" tabindex="-1" role="dialog"
    aria-labelledby="itemDetailsModalLabel{{ $item->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="itemDetailsModalLabel{{ $item->id }}">
                    {{ $item->name }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-5">
                        <img class="rounded image-modal" alt="{{ trans('lang.item_image') }}"
                            src="{{ $item->media[0]->image ?? $noneImage }}">
                    </div>
                    <div class="col-md-7">
                        <p><strong>{{ trans('lang.item_describion') }}:</strong> {{ $item->desc }}</p>
                        <p>
                            <strong>{{ trans('lang.category') }}:</strong>
                            <a href="{{ route('categories.category', $item->category_id) }}">
                                {{ $item->category->name }}
                            </a>
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
