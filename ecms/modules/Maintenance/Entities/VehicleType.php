<?php


namespace Modules\Maintenance\Entities;

/**
 * Class VehicleType
 * @package Modules\Maintenance\Entities
 */

class VehicleType
{
    const PASSENGERS = 0;
    const CARGO = 1;
    const YELLOWMACHINERY = 2;
    /**
     * @var array
     */
    private array $types = [];

    public function __construct()
    {
        $this->types = [
            self::PASSENGERS => trans('transport::vehicles.type.passengers'),
            self::CARGO => trans('transport::vehicles.type.cargo'),
            self::YELLOWMACHINERY => trans('transport::vehicles.type.yellow machinery'),
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

        return $this->types[self::PASSENGERS];
    }
}
