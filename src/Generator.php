<?php

namespace MohammadAlavi\LaravelOpenApi;

use Illuminate\Support\Arr;
use MohammadAlavi\LaravelOpenApi\Builders\ComponentBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\InfoBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\PathBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\ServerBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\TagBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\OpenApi;

class Generator
{
    public const COLLECTION_DEFAULT = 'default';
    public string $version = OpenApi::OPENAPI_3_0_2;

    public function __construct(
        private readonly array $config,
        private readonly InfoBuilder $infoBuilder,
        private readonly ServerBuilder $serverBuilder,
        private readonly TagBuilder $tagBuilder,
        private readonly PathBuilder $pathBuilder,
        private readonly ComponentBuilder $componentBuilder,
    ) {
    }

    public function generate(string $collection = self::COLLECTION_DEFAULT): OpenApi
    {
        $info = $this->infoBuilder->build($this->getConfigFor('info', $collection));
        $servers = $this->serverBuilder->build($this->getConfigFor('servers', $collection));
        $extensions = $this->getConfigFor('extensions', $collection);
        $security = $this->getConfigFor('security', $collection);

        $middlewaresConfig = $this->getConfigFor('middlewares', $collection);
        $paths = $this->pathBuilder->build($collection, Arr::get($middlewaresConfig, 'paths', []));
        $components = $this->componentBuilder->build($collection, Arr::get($middlewaresConfig, 'components', []));
        $tags = $this->tagBuilder->build($this->getConfigFor('tags', $collection));

        $openApi = OpenApi::create()
            ->openapi(OpenApi::OPENAPI_3_0_2)
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
