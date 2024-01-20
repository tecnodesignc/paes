<?php

namespace Modules\Transport\Repositories\Cache;

use Modules\Transport\Repositories\DocumentRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheDocumentDecorator extends BaseCacheDecorator implements DocumentRepository
{
    public function __construct(DocumentRepository $document)
    {
        parent::__construct();
        $this->entityName = 'transport.documents';
        $this->repository = $document;
    }
}
