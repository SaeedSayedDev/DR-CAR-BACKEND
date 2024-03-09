<div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="messageModalLabel"
aria-hidden="true">
<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="messageModalLabel">{{ trans('lang.message_plural') }}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="message">{{ trans('lang.message') }}</label>
                <textarea class="form-control" id="message" rows="3"></textarea>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                {{ trans('lang.close') }}
            </button>
            <button id="sendMessageButton" type="button" class="btn btn-primary">
                {{ trans('lang.message_send') }}
            </button>
        </div>
    </div>
</div>
</div>
