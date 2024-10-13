<?php

namespace MohammadAlavi\LaravelOpenApi;

use Illuminate\Support\Arr;
use MohammadAlavi\LaravelOpenApi\Builders\Components\ComponentsBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\InfoBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation\SecurityBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\Paths\PathsBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\ServerBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\TagBuilder;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\PathMiddleware;
use MohammadAlavi\ObjectOrientedOpenAPI\Extensions\Extension;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\OpenApi;
use Tests\Doubles\Fakes\Petstore\Security\ExampleSingleSecurityRequirementSecurity;

class Generator
{
    // TODO: Is this the right place for this constant?
    public const COLLECTION_DEFAULT = 'default';

    public function __construct(
        private readonly InfoBuilder $infoBuilder,
        private readonly ServerBuilder $serverBuilder,
        private readonly TagBuilder $tagBuilder,
        private readonly SecurityBuilder $securityBuilder,
        private readonly PathsBuilder $pathsBuilder,
        private readonly ComponentsBuilder $componentsBuilder,
    ) {
    }

    public function generate(string $collection = self::COLLECTION_DEFAULT): OpenApi
    {
        $info = $this->infoBuilder->build($this->getConfigFor('info', $collection));
        $servers = $this->serverBuilder->build($this->getConfigFor('servers', $collection));
        $extensions = $this->getConfigFor('extensions', $collection);
        // TODO: dont miss this hard coded value! It is just for testing purposes.
        $security = $this->securityBuilder->build(ExampleSingleSecurityRequirementSecurity::class);
//        $security = $this->securityBuilder->build($this->getConfigFor('security', $collection));
        $middlewaresConfig = $this->getConfigFor('middlewares', $collection);
        $paths = $this->pathsBuilder->build($collection, ...$this->getMiddlewares($middlewaresConfig));
        $components = $this->componentsBuilder->build($collection, Arr::get($middlewaresConfig, 'components', []));
        $tags = $this->tagBuilder->build($this->getConfigFor('tags', $collection));

        $openApi = OpenApi::create()
            ->info($info)
            ->servers(...$servers)
            ->paths($paths)
            ->components($components)
            ->security($security)
            ->tags(...$tags);

        foreach ($extensions as $key => $value) {
            $openApi = $openApi->addExtension(Extension::create($key, $value));
        }

        return $openApi;
    }

    private function getConfigFor(string $configKey, string $collection): array
    {
        return Arr::get(config('openapi'), 'collections.' . $collection . '.' . $configKey, []);
    }

    /** @return PathMiddleware[] */
    private function getMiddlewares(array $middlewaresConfig): array
    {
        return Arr::map(
            Arr::get($middlewaresConfig, 'paths', []),
            static fn (string $middlewares) => app($middlewares),
        );
    }
}
