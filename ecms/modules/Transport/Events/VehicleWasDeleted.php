<?php

namespace Modules\Blog\Events;

use Modules\Media\Contracts\DeletingMedia;

class VehicleWasDeleted implements DeletingMedia
{
    /**
     * @var string
     */
    private string $vehicleClass;
    /**
     * @var int
     */
    private int $vehicleId;

    /**
     * @param $vehicleId
     * @param $vehicleClass
     */
    public function __construct($vehicleId, $vehicleClass)
    {
        $this->vehicleClass = $vehicleClass;
        $this->vehicleId = $vehicleId;
    }

    /**
     * Get the entity ID
     * @return int
     */
    public function getEntityId(): int
    {
        return $this->vehicleId;
    }

    /**
     * Get the class name the imageables
     * @return string
     */
    public function getClassName(): string
    {
        return $this->vehicleClass;
    }
}
