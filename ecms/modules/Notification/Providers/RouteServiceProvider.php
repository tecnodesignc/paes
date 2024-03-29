<?php

namespace Modules\Notification\Providers;

use Modules\Core\Providers\RoutingServiceProvider as CoreRoutingServiceProvider;

class RouteServiceProvider extends CoreRoutingServiceProvider
{
    /**
     * The root namespace to assume when generating URLs to actions.
     * @var string
     */
    protected $namespace = 'Modules\Notification\Http\Controllers';

    /**
     * @return string|boolean
     */
    protected function getFrontendRoute(): bool|string
    {
        return false;
    }

    /**
     * @return string
     */
    protected function getBackendRoute(): string
    {
        return __DIR__ . '/../Http/backendRoutes.php';
    }

    /**
     * @return string
     */
    protected function getApiRoute(): string
    {
        return __DIR__ . '/../Http/apiRoutes.php';
    }
}
