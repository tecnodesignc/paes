<?php

namespace Modules\Dynamicform\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Dynamicform\Entities\FormResponse;
// paquete para imagenes
use Modules\Media\Contracts\StoringMedia;

class FormResponsesWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public array $data;
    /**
     * @var FormResponse
     */
    public FormResponse $formresponse;

    /**
     * @param $formresponse
     * @param array $data
     */
    public function __construct($formresponse, array $data)
    {
        $this->data = $data;
        $this->formresponse = $formresponse;
    }

    /**
     * Return the entity
     * @return Model
     */
    public function getEntity(): Model
    {
        return $this->formresponse;
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
