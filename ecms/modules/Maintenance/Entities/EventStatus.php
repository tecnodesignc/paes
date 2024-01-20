<?php


namespace Modules\Maintenance\Entities;

/**
 * Class Status
 * @package Modules\Maintenance\Entities
 */
class EventStatus
{
    const PENDING = 0;
    const SCHEDULED = 1;
    const DONE = 2;
    const EXPIRED = 3;
    const CANCELED = 4;
    /**
     * @var array
     */
    private array $statuses = [];

    public function __construct()
    {
        $this->statuses = [
            self::PENDING => trans('maintenance::events.status.pending'),
            self::SCHEDULED => trans('maintenance::events.status.scheduled'),
            self::DONE => trans('maintenance::events.status.done'),
            self::EXPIRED => trans('maintenance::events.status.expired'),
            self::CANCELED => trans('maintenance::events.status.canceled'),
        ];
    }

    /**
     * Get the available statuses
     * @return array
     */
    public function lists(): array
    {
        return $this->statuses;
    }

    /**
     * Get the post status
     * @param int $statusId
     * @return string
     */
    public function get(int $statusId): string
    {
        if (isset($this->statuses[$statusId])) {
            return $this->statuses[$statusId];
        }

        return $this->statuses[self::PENDING];
    }
}
