<?php

namespace Modules\Notification\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Modules\Core\Repositories\BaseRepository;

/**
 * Interface NotificationRepository
 * @package Modules\Notification\Repositories
 */
interface NotificationRepository extends BaseRepository
{
    /**
     * @param int $userId
     * @return Collection
     */
    public function latestForUser(int $userId): Collection;

    /**
     * Mark the given notification id as "read"
     * @param int $notificationId
     * @return bool
     */
    public function markNotificationAsRead(int $notificationId): bool;

    /**
     * Get all the notifications for the given user id
     * @param int $userId
     * @return Collection
     */
    public function allForUser(int $userId): Collection;

    /**
     * Get all the unread notifications for the given user id
     * @param int $userId
     * @return Collection
     */
    public function allUnreadForUser(int $userId): Collection;

    /**
     * Get all the read notifications for the given user id
     * @param int $userId
     * @return Collection
     */
    public function allReadForUser(int $userId): Collection;

    /**
     * Delete all the notifications for the given user
     * @param int $userId
     * @return bool
     */
    public function deleteAllForUser(int $userId): bool;

    /**
     * Mark all the notifications for the given user as read
     * @param int $userId
     * @return bool
     */
    public function markAllAsReadForUser(int $userId): bool;
}
