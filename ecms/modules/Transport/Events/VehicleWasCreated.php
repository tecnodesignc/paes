<?php

namespace Modules\Transport\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Transport\Entities\Vehicles;
use Modules\Media\Contracts\StoringMedia;

class VehicleWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public array $data;
    /**
     * @var Vehicles
     */
    public Vehicles $vehicle;

    /**
     * @param $vehicle
     * @param array $data
     */
    public function __construct($vehicle, array $data)
    {
        $this->data = $data;
        $this->vehicle = $vehicle;
    }

    /**
     * Return the entity
     * @return Model
     */
    public function getEntity(): Model
    {
        return $this->vehicle;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData(): array
    {
        return $this->data;
    }
}
