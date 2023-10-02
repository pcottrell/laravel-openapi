<?php

declare(strict_types=1);

namespace MohammadAlavi\LaravelOpenApi;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use MohammadAlavi\LaravelOpenApi\Builders\ComponentBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Components\CallbackBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Components\RequestBodyBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Components\ResponseBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Components\SchemaBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Components\SecuritySchemeBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\InfoBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\PathBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\ServerBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\TagBuilder;

class OpenApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/openapi.php',
            'openapi'
        );

        $this->app->bind(CallbackBuilder::class, function () {
            return new CallbackBuilder($this->getPathsFromConfig('callbacks'));
        });

        $this->app->bind(RequestBodyBuilder::class, function () {
            return new RequestBodyBuilder($this->getPathsFromConfig('request_bodies'));
        });

        $this->app->bind(ResponseBuilder::class, function () {
            return new ResponseBuilder($this->getPathsFromConfig('responses'));
        });

        $this->app->bind(SchemaBuilder::class, function () {
            return new SchemaBuilder($this->getPathsFromConfig('schemas'));
        });

        $this->app->bind(SecuritySchemeBuilder::class, function () {
            return new SecuritySchemeBuilder($this->getPathsFromConfig('security_schemes'));
        });

        $this->app->singleton(Generator::class, static function (Application $app) {
            $config = config('openapi');

            return new Generator(
                $config,
                $app->make(InfoBuilder::class),
                $app->make(ServerBuilder::class),
                $app->make(TagBuilder::class),
                $app->make(PathBuilder::class),
                $app->make(ComponentBuilder::class)
            );
        });

        $this->commands([
            Console\GenerateCommand::class,
        ]);

        if ($this->app->runningInConsole()) {
            $this->commands([
                Console\CallbackFactoryMakeCommand::class,
                Console\ExtensionFactoryMakeCommand::class,
                Console\ParametersFactoryMakeCommand::class,
                Console\RequestBodyFactoryMakeCommand::class,
                Console\ResponseFactoryMakeCommand::class,
                Console\SchemaFactoryMakeCommand::class,
                Console\SecuritySchemeFactoryMakeCommand::class,
            ]);
        }
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/openapi.php' => config_path('openapi.php'),
            ], 'openapi-config');
        }

        $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
    }

    private function getPathsFromConfig(string $type): array
    {
        $directories = config('openapi.locations.' . $type, []);

        foreach ($directories as &$directory) {
            $directory = glob($directory, GLOB_ONLYDIR);
        }

        return (new Collection($directories))
            ->flatten()
            ->unique()
            ->toArray();
    }
}
