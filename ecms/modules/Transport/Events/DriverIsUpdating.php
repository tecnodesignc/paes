<?php

namespace Modules\Transport\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;
use Modules\Transport\Entities\Driver;

class DriverIsUpdating extends AbstractEntityHook implements EntityIsChanging
{

    /**
     * @var array
     */
    public array $data;

    public Driver $driver;

    public function __construct( $driver, array $data)
    {
        $this->driver=$driver;
        $this->data = $data;
    }
    /**
     * Return the entity
     * @return Model
     */
    public function getEntity(): Model
    {
        return $this->driver;
    }

    /**
     * Return the ALL data sent
     * @return array
     */
    public function getSubmissionData():array
    {
        return $this->data;
    }


}
