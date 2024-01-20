<?php

namespace Modules\Dynamicform\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Dynamicform\Events\Handlers\RegisterDynamicformSidebar;

class DynamicformServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterDynamicformSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('forms', Arr::dot(trans('dynamicform::forms')));
            $event->load('fields', Arr::dot(trans('dynamicform::fields')));
            $event->load('formresponses', Arr::dot(trans('dynamicform::formresponses')));
            // append translations



        });
    }

    public function boot()
    {
        $this->publishConfig('dynamicform', 'config');
        $this->publishConfig('dynamicform', 'permissions');
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
            'Modules\Dynamicform\Repositories\FormRepository',
            function () {
                $repository = new \Modules\Dynamicform\Repositories\Eloquent\EloquentFormRepository(new \Modules\Dynamicform\Entities\Form());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Dynamicform\Repositories\Cache\CacheFormDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Dynamicform\Repositories\FieldRepository',
            function () {
                $repository = new \Modules\Dynamicform\Repositories\Eloquent\EloquentFieldRepository(new \Modules\Dynamicform\Entities\Field());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Dynamicform\Repositories\Cache\CacheFieldDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Dynamicform\Repositories\FormResponseRepository',
            function () {
                $repository = new \Modules\Dynamicform\Repositories\Eloquent\EloquentFormResponseRepository(new \Modules\Dynamicform\Entities\FormResponse());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Dynamicform\Repositories\Cache\CacheFormResponseDecorator($repository);
            }
        );
// add bindings



    }
}
