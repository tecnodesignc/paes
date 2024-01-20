<?php

namespace Modules\Notification\Composers;

use Illuminate\Contracts\View\View;
use Modules\Notification\Repositories\NotificationRepository;
use Modules\User\Contracts\Authentication;

class NotificationViewComposer
{
    /**
     * @var NotificationRepository
     */
    private NotificationRepository $notification;
    /**
     * @var Authentication
     */
    private Authentication $auth;

    public function __construct(NotificationRepository $notification, Authentication $auth)
    {
        $this->notification = $notification;
        $this->auth = $auth;
    }

    /**
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        $notifications = $this->notification->latestForUser($this->auth->id());
        $view->with('notifications', $notifications);
    }
}
