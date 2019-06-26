<?php
/**
 * @link https://github.com/vuongxuongminh/laravel-view-localization
 *
 * @copyright (c) Vuong Xuong Minh
 * @license [MIT](https://opensource.org/licenses/MIT)
 */

namespace VXM\ViewLocalization;

use Illuminate\Support\ServiceProvider;

/**
 * @author Vuong Minh <vuongxuongminh@gmail.com>
 * @since  1.0.0
 */
class ViewLocalizationServiceProvider extends ServiceProvider
{
    /**
     * Boot package services.
     */
    public function boot(): void
    {
        $this->publishConfigs();
        $this->registerViewComposeListener();
    }

    /**
     * Publish package config files.
     */
    protected function publishConfigs(): void
    {
        $this->publishes([
            __DIR__.'/../config/viewlocalization.php' => config_path('viewlocalization.php'),
        ], 'config');
    }

    /**
     * Register view compose event listener.
     */
    protected function registerViewComposeListener(): void
    {
        $this->app['view']->composer('*', ViewComposer::class);
    }

    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->mergeDefaultConfigs();
        $this->registerServices();
    }

    /**
     * Merge default package configs.
     */
    protected function mergeDefaultConfigs(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/viewlocalization.php', 'viewlocalization');
    }

    /**
     * Register package services.
     */
    protected function registerServices(): void
    {
        $this->app->singleton(ViewComposer::class, function ($app) {
            return new ViewComposer(
                $app,
                $app['config']->get('viewlocalization.sourceLocale'),
                $app['files']
            );
        });
    }
}
