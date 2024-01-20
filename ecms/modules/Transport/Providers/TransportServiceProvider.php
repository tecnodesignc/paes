<?php

namespace Modules\Transport\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Transport\Events\Handlers\RegisterTransportSidebar;

class TransportServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterTransportSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('vehicles', Arr::dot(trans('transport::vehicles')));;
            $event->load('documents', Arr::dot(trans('transport::documents')));
            $event->load('drivers', Arr::dot(trans('transport::drivers')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('transport', 'permissions');

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
            'Modules\Transport\Repositories\VehiclesRepository',
            function () {
                $repository = new \Modules\Transport\Repositories\Eloquent\EloquentVehiclesRepository(new \Modules\Transport\Entities\Vehicles());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Transport\Repositories\Cache\CacheVehiclesDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Transport\Repositories\DocumentRepository',
            function () {
                $repository = new \Modules\Transport\Repositories\Eloquent\EloquentDocumentRepository(new \Modules\Transport\Entities\Document());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Transport\Repositories\Cache\CacheDocumentDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Transport\Repositories\DriverRepository',
            function () {
                $repository = new \Modules\Transport\Repositories\Eloquent\EloquentDriverRepository(new \Modules\Transport\Entities\Driver());

                if (!config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Transport\Repositories\Cache\CacheDriverDecorator($repository);
            }
        );
// add bindings

    }
}
