<?php


namespace Modules\Transport\Entities;

/**
 * Class VehicleType
 * @package Modules\Maintenance\Entities
 */

class TransmissionType
{
    const MANUAL = 0;
    const AUTOMATIC = 1;
    const SEMIAUTOMATIC = 2;
    const DUALCLUTCH = 2;
    const CONTINUOUSLYVARIABLE = 2;
    /**
     * @var array
     */
    private array $types = [];

    public function __construct()
    {
        $this->types = [
            self::MANUAL => trans('transport::vehicles.transmission_type.manual'),
            self::AUTOMATIC => trans('transport::vehicles.transmission_type.automatic'),
            self::SEMIAUTOMATIC => trans('transport::vehicles.transmission_type.semiautomatic'),
            self::DUALCLUTCH => trans('transport::vehicles.dual clutch'),
            self::CONTINUOUSLYVARIABLE => trans('transport::vehicles.transmission_type.continuously variable'),
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
