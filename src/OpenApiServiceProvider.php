<?php

namespace MohammadAlavi\LaravelOpenApi;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use MohammadAlavi\LaravelOpenApi\Collectors\CollectionLocator;
use MohammadAlavi\LaravelOpenApi\Collectors\ComponentCollector;
use MohammadAlavi\LaravelOpenApi\Collectors\Components\CallbackCollector;
use MohammadAlavi\LaravelOpenApi\Collectors\Components\RequestBodyCollector;
use MohammadAlavi\LaravelOpenApi\Collectors\Components\ResponseCollector;
use MohammadAlavi\LaravelOpenApi\Collectors\Components\SchemaCollector;
use MohammadAlavi\LaravelOpenApi\Collectors\Components\SecuritySchemeCollector;
use MohammadAlavi\LaravelOpenApi\Collectors\InfoBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\PathBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\ServerBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\TagBuilder;
use MohammadAlavi\LaravelOpenApi\Contracts\RouteCollector;
use MohammadAlavi\LaravelOpenApi\Http\OpenApiController;

class OpenApiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/openapi.php',
            'openapi',
        );

        $this->app->singleton(
            CallbackCollector::class,
            fn (Application $application): CallbackCollector => new CallbackCollector(
                new CollectionLocator(
                    $this->getPathsFromConfig('callbacks'),
                ),
            ),
        );

        $this->app->singleton(
            RequestBodyCollector::class,
            fn (Application $application): RequestBodyCollector => new RequestBodyCollector(
                new CollectionLocator(
                    $this->getPathsFromConfig('request_bodies'),
                ),
            ),
        );

        $this->app->singleton(
            ResponseCollector::class,
            fn (Application $application): ResponseCollector => new ResponseCollector(
                new CollectionLocator(
                    $this->getPathsFromConfig('responses'),
                ),
            ),
        );

        $this->app->singleton(
            SchemaCollector::class,
            fn (Application $application): SchemaCollector => new SchemaCollector(
                new CollectionLocator(
                    $this->getPathsFromConfig('schemas'),
                ),
            ),
        );

        $this->app->singleton(
            SecuritySchemeCollector::class,
            fn (Application $application): SecuritySchemeCollector => new SecuritySchemeCollector(
                new CollectionLocator(
                    $this->getPathsFromConfig('security_schemes'),
                ),
            ),
        );

        $this->app->singleton(
            Generator::class,
            static function (Application $application): Generator {
                $config = config(
                    'openapi',
                );

                return new Generator(
                    $config,
                    $application->make(InfoBuilder::class),
                    $application->make(ServerBuilder::class),
                    $application->make(TagBuilder::class),
                    $application->make(PathBuilder::class),
                    $application->make(ComponentCollector::class),
                );
            },
        );

        $this->app->bind(RouteCollector::class, Collectors\RouteCollector::class);

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

    private function getPathsFromConfig(string $type): array
    {
        $directories = config('openapi.locations.' . $type, []);

        foreach ($directories as &$directory) {
            $directory = glob($directory, GLOB_ONLYDIR);
        }

        return Collection::make($directories)
            ->flatten()
            ->unique()
            ->toArray();
    }

    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/openapi.php' => config_path('openapi.php'),
            ], 'openapi-config');
        }

        // TODO: allow to disable this, so user can register their own routes.
        //  Like how Laravel Passport does it.
        Route::group(['as' => 'openapi.'], static function (): void {
            foreach (config('openapi.collections', []) as $name => $config) {
                $uri = Arr::get($config, 'route.uri');

                if (!$uri) {
                    continue;
                }

                Route::get($uri, [OpenApiController::class, 'show'])
                    ->name($name . '.specification')
                    ->prefix('/api')
                    ->middleware(['api', ...Arr::get($config, 'route.middleware')]);
            }
        });
    }
}
