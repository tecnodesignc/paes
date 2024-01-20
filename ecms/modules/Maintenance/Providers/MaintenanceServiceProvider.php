<?php

namespace Modules\Maintenance\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Maintenance\Events\Handlers\RegisterMaintenanceSidebar;

class MaintenanceServiceProvider extends ServiceProvider
{
    use CanPublishConfiguration;
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
        $this->app['events']->listen(BuildingSidebar::class, RegisterMaintenanceSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('events', Arr::dot(trans('maintenance::events')));
            $event->load('fueltanks', Arr::dot(trans('maintenance::fueltanks')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('maintenance', 'config');
        $this->publishConfig('maintenance', 'permissions');
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    private function registerBindings()
    {
        $this->app->bind(
            'Modules\Maintenance\Repositories\EventRepository',
            function () {
                $repository = new \Modules\Maintenance\Repositories\Eloquent\EloquentEventRepository(new \Modules\Maintenance\Entities\Event());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Maintenance\Repositories\Cache\CacheEventDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Maintenance\Repositories\FueltankRepository',
            function () {
                $repository = new \Modules\Maintenance\Repositories\Eloquent\EloquentFueltankRepository(new \Modules\Maintenance\Entities\Fueltank());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Maintenance\Repositories\Cache\CacheFueltankDecorator($repository);
            }
        );
// add bindings


    }
}
