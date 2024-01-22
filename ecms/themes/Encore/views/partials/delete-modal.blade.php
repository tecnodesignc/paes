<div class="modal fade" id="modal-delete-confirmation" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-danger">
            <div class="modal-header">
                <h5 class="modal-title text-white">{{ trans('core::core.modal.title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-white">
                @isset($message)
                    {!! $message !!}
                @else
                    {{ trans('core::core.modal.confirmation-message') }}
                @endisset
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    {{ trans('core::core.button.cancel') }}
                </button>
                {!! Form::open(['method' => 'delete', 'class' => 'pull-left']) !!}
                <button type="submit" class="btn btn-dark"> <i class="bx bx-trash-alt"></i> {{ trans('core::core.button.delete') }}</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

@section('script')
    @parent
<script type="application/javascript" async>
    $(function() {
        "use strict";
        $(document).ready(function () {
            $('#modal-delete-confirmation').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var actionTarget = button.data('action-target');
                console.log(actionTarget)
                var modal = $(this);
                modal.find('form').attr('action', actionTarget);

                if (button.data('message') === undefined) {
                } else if (button.data('message') != '') {
                    modal.find('.custom-message').show().empty().append(button.data('message'));
                    modal.find('.default-message').hide();
                } else {
                    modal.find('.default-message').show();
                    modal.find('.custom-message').hide();
                }

                if (button.data('remove-submit-button') === true) {
                    modal.find('button[type=submit]').hide();
                } else {
                    modal.find('button[type=submit]').show();
                }
            });
        });
    });
</script>
@stop
