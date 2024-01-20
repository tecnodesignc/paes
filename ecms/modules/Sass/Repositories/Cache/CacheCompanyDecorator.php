<?php

namespace Modules\Sass\Repositories\Cache;

use Modules\Sass\Repositories\CompanyRepository;
use Modules\Core\Repositories\Cache\BaseCacheDecorator;

class CacheCompanyDecorator extends BaseCacheDecorator implements CompanyRepository
{
    public function __construct(CompanyRepository $company)
    {
        parent::__construct();
        $this->entityName = 'sass.companies';
        $this->repository = $company;
    }
}
