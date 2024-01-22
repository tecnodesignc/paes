<div class="dropdown d-inline-block">
    <button type="button" class="btn header-item noti-icon" id="page-header-notifications-dropdown"
            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="icon-sm" data-feather="bell"></i>
        <span class="noti-dot bg-danger rounded-pill font-size-10 pt-1">{{count($notifications)<10?count($notifications):'+9'}}</span>
    </button>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
         aria-labelledby="page-header-notifications-dropdown">
        <div class="p-3">
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="m-0 font-size-15"> Notificaciones </h5>
                </div>
<!--                <div class="col-auto">
                    <a href="#!" class="small"> Mark all as read</a>
                </div>-->
            </div>
        </div>
        <div data-simplebar style="max-height: 250px;">
            @if ($notifications->count() === 0)
                <h6 class="dropdown-header bg-light"> {{ trans('notification::messages.no notifications') }}</h6>
            @else
                <h6 class="dropdown-header bg-light">Nuevas</h6>
            @endif
            @foreach ($notifications as $notification)
            <a href="{!! $notification->link !!}" class="text-reset notification-item removeNotification">
                <div class="d-flex border-bottom align-items-start">
                    <div class="flex-shrink-0">
                        <div class="me-3 rounded-circle avatar-sm">{!! $notification->icon_class !!}</div>
                    </div>
                    <div class="flex-grow-1">
                        <h6 class="mb-1">{{ $notification->title }}</h6>
                        <div class="text-muted">
                            <p class="mb-1 font-size-13">{{ $notification->message }} </p>
                            <p class="mb-0 font-size-10 text-uppercase fw-bold"><i class="mdi mdi-clock-outline"></i> {{ $notification->time_ago }}</p>
                        </div>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
        <div class="p-2 border-top d-grid">
            <a class="btn btn-sm btn-link font-size-14 btn-block text-center" href="{{route('account.profile.view')}}#notification">
                <i class="uil-arrow-circle-right me-1"></i> <span>Ver Mas</span>
            </a>
        </div>
    </div>
</div>

@section('script')
    @parent
    <script>
        $( document ).ready(function() {
            $('.removeNotification').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                var self = this;
                $.ajax({
                    type: 'POST',
                    url: '{{ route('api.notification.read') }}',
                    data: {
                        'id': $(this).data('id'),
                        '_token': '{{ csrf_token() }}'
                    },
                    success: function(data) {
                        if (data.updated) {
                            var notification = $(self).closest('li');
                            notification.addClass('animated fadeOut');
                            setTimeout(function() {
                                notification.remove();
                            }, 510)
                            var count = parseInt($('.notificationsCounter').text());
                            $('.notificationsCounter').text(count - 1);
                        }
                    }
                });
            });
        });
    </script>
    <script src="https://js.pusher.com/4.1/pusher.min.js"></script>
    <script src="{{ Theme::url('js/notification.js')}}"></script>
    <script>
        $('.notifications-list').pusherNotifications({
            pusherKey: '{{ config('broadcasting.connections.pusher.key') }}',
            pusherCluster: '{{ config('broadcasting.connections.pusher.options.cluster') }}',
            pusherEncrypted: '{{ config('broadcasting.connections.pusher.options.encrypted') }}',
            loggedInUserId: {{ $currentUser->id }},
        });
    </script>
@stop
