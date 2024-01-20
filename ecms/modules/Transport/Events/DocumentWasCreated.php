<?php

namespace modules\Transport\Events;

use Illuminate\Database\Eloquent\Model;
use Modules\Transport\Entities\Document;
use Modules\Media\Contracts\StoringMedia;

class DocumentWasCreated implements StoringMedia
{
    /**
     * @var array
     */
    public array $data;
    /**
     * @var Document
     */
    public Document $document;

    /**
     * @param $document
     * @param array $data
     */
    public function __construct($document, array $data)
    {
        $this->data = $data;
        $this->document = $document;
    }

    /**
     * Return the entity
     * @return Model
     */
    public function getEntity(): Model
    {
        return $this->document;
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
