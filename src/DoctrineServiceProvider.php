<?php

namespace Furesz\Doctrine;

use Doctrine\ORM\EntityManager;
use Furesz\Doctrine\Config\ConfigReader;
use Illuminate\Support\ServiceProvider;

class DoctrineServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../templates/doctrine.php' => config_path('doctrine.php'),
                __DIR__ . '/../templates/cli-config.php' => config_path('cli-config.php'),
            ]
        );
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $config = new ConfigReader();

        $this->app->singleton(
            EntityManager::class,
            function () use ($config) {
                return EntityManager::create(
                    $config->getConnection(),
                    $this->createDoctrineConfig($this->createCache()),
                    $this->createEventManager()
                );
            }
        );
    }
}
