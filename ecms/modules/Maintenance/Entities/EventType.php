<?php


namespace Modules\Maintenance\Entities;

/**
 * Class Status
 * @package Modules\Maintenance\Entities
 */

class EventType
{
    const TASK = 0;
    const REMINDER = 1;
    const PREVENTIVEMAINTENANCE = 2;
    const CORRECTIVEMAINTENANCE = 3;
    /**
     * @var array
     */
    private array $types = [];

    public function __construct()
    {
        $this->types = [
            self::TASK => trans('maintenance::events.type.task'),
            self::REMINDER => trans('maintenance::events.type.reminder'),
            self::PREVENTIVEMAINTENANCE => trans('maintenance::events.type.preventive maintenance'),
            self::CORRECTIVEMAINTENANCE => trans('maintenance::events.type.corrective maintenance'),
        ];
    }

    /**
     * Get the available types
     * @return array
     */
    public function lists(): array
    {
        return $this->types;
    }

    /**
     * Get the post type
     * @param int $typeId
     * @return string
     */
    public function get(int $typeId): string
    {
        if (isset($this->types[$typeId])) {
            return $this->types[$typeId];
        }

        return $this->types[self::TASK];
    }
}
