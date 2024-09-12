<?php

namespace MohammadAlavi\LaravelOpenApi;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\CircularDependencyException;
use Illuminate\Support\Arr;
use MohammadAlavi\LaravelOpenApi\Collectors\ComponentCollector;
use MohammadAlavi\LaravelOpenApi\Collectors\InfoBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\PathBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\ServerBuilder;
use MohammadAlavi\LaravelOpenApi\Collectors\TagBuilder;
use MohammadAlavi\LaravelOpenApi\Enums\OpenAPIVersion;
use MohammadAlavi\LaravelOpenApi\Objects\OpenApi;
use MohammadAlavi\ObjectOrientedOAS\Exceptions\InvalidArgumentException;

class Generator
{
    public const COLLECTION_DEFAULT = 'default';

    // TODO: Document the OpenAPIVersion enum
    public OpenAPIVersion $version = OpenAPIVersion::OPENAPI_3_1_0;

    public function __construct(
        private readonly array $config,
        private readonly InfoBuilder $infoBuilder,
        private readonly ServerBuilder $serverBuilder,
        private readonly TagBuilder $tagBuilder,
        private readonly PathBuilder $pathBuilder,
        private readonly ComponentCollector $componentCollector,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     * @throws BindingResolutionException
     * @throws CircularDependencyException
     */
    public function generate(string $collection = self::COLLECTION_DEFAULT): OpenApi
    {
        $info = $this->infoBuilder->build($this->getConfigFor('info', $collection));
        $servers = $this->serverBuilder->build($this->getConfigFor('servers', $collection));
        $extensions = $this->getConfigFor('extensions', $collection);
        $security = $this->getConfigFor('security', $collection);

        $middlewaresConfig = $this->getConfigFor('middlewares', $collection);
        $paths = $this->pathBuilder->build($collection, Arr::get($middlewaresConfig, 'paths', []));
        $components = $this->componentCollector->collect($collection, Arr::get($middlewaresConfig, 'components', []));
        $tags = $this->tagBuilder->build($this->getConfigFor('tags', $collection));

        $openApi = OpenApi::create()
            ->openapi($this->version->value) // TODO: Update method to accept OpenAPIVersion enum instead of string
            ->info($info)
            ->servers(...$servers)
            ->paths(...$paths)
            ->components($components)
            ->multiAuthSecurity($security)
            ->tags(...$tags);

        foreach ($extensions as $key => $value) {
            $openApi = $openApi->x($key, $value);
        }

        return $openApi;
    }

    private function getConfigFor(string $configKey, string $collection): array
    {
        return Arr::get($this->config, 'collections.' . $collection . '.' . $configKey, []);
    }
}
