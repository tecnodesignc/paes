<?php

namespace Modules\Sass\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use Modules\Core\Traits\CanPublishConfiguration;
use Modules\Core\Events\BuildingSidebar;
use Modules\Core\Events\LoadingBackendTranslations;
use Modules\Sass\Events\Handlers\RegisterSassSidebar;

class SassServiceProvider extends ServiceProvider
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
        $this->app['events']->listen(BuildingSidebar::class, RegisterSassSidebar::class);

        $this->app['events']->listen(LoadingBackendTranslations::class, function (LoadingBackendTranslations $event) {
            $event->load('companies', Arr::dot(trans('sass::companies')));
            $event->load('settings', Arr::dot(trans('sass::settings')));
            // append translations


        });
    }

    public function boot()
    {
        $this->publishConfig('sass', 'permissions');

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
            'Modules\Sass\Repositories\CompanyRepository',
            function () {
                $repository = new \Modules\Sass\Repositories\Eloquent\EloquentCompanyRepository(new \Modules\Sass\Entities\Company());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Sass\Repositories\Cache\CacheCompanyDecorator($repository);
            }
        );
        $this->app->bind(
            'Modules\Sass\Repositories\SettingRepository',
            function () {
                $repository = new \Modules\Sass\Repositories\Eloquent\EloquentSettingRepository(new \Modules\Sass\Entities\Setting());

                if (! config('app.cache')) {
                    return $repository;
                }

                return new \Modules\Sass\Repositories\Cache\CacheSettingDecorator($repository);
            }
        );
// add bindings


    }
}
