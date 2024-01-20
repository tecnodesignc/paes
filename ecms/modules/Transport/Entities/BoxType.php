<?php


namespace Modules\Transport\Entities;

/**
 * Class VehicleType
 * @package Modules\Maintenance\Entities
 */

class BoxType
{
    const MANUAL = 0;
    const MECHANICAL = 1;
    /**
     * @var array
     */
    private array $types = [];

    public function __construct()
    {
        $this->types = [
            self::MANUAL => trans('transport::vehicles.box_type.manual'),
            self::MECHANICAL => trans('transport::vehicles.box_type.mechanical'),
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

        return $this->types[self::MANUAL];
    }
}
