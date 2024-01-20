<?php

namespace Modules\Transport\Events;

use Modules\Core\Contracts\EntityIsChanging;
use Modules\Core\Events\AbstractEntityHook;

class DriverIsCreating extends AbstractEntityHook implements EntityIsChanging
{

    /**
     * @var array
     */
    public array $data;

    public function __construct( array $data)
    {
        $this->data = $data;
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
