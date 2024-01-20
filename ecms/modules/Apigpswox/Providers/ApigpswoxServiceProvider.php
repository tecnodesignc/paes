<?php

namespace Modules\Apigpswox\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Apigpswox\Events\Handlers\RegisterApigpswoxSidebar;

class ApigpswoxServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterApigpswoxSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('tokens', Arr::dot(trans('apigpswox::tokens')));
            // append translations

        });
    }

    public function boot()
    {
        $this->publishConfig('apigpswox', 'permissions');

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
            'Modules\Apigpswox\Repositories\TokenRepository',
            function () {
                $repository = new \Modules\Apigpswox\Repositories\Eloquent\EloquentTokenRepository(new \Modules\Apigpswox\Entities\Token());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Apigpswox\Repositories\Cache\CacheTokenDecorator($repository);
            }
        );
// add bindings

    }
}
