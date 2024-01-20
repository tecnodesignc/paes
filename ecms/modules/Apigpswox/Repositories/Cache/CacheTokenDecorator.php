<?php

namespace Modules\Apigpswox\Repositories\Cache;

use Modules\Apigpswox\Repositories\TokenRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheTokenDecorator extends BaseCacheDecorator implements TokenRepository
{
    public function __construct(TokenRepository $token)
    {
        parent::__construct();
        $this->entityName = 'apigpswox.tokens';
        $this->repository = $token;
    }
}
