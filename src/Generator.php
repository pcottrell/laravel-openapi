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
    public string $version = OpenApi::OPENAPI_3_0_2;
    public const COLLECTION_DEFAULT = 'default';

    public function __construct(
        private array $config,
        private InfoBuilder $infoBuilder,
        private ServerBuilder $serverBuilder,
        private TagBuilder $tagBuilder,
        private PathBuilder $pathBuilder,
        private ComponentBuilder $componentBuilder,
    ) {
    }

    public function generate(string $collection = self::COLLECTION_DEFAULT): OpenApi
    {
        $middlewares = Arr::get($this->config, 'collections.' . $collection . '.middlewares');

        $info = $this->infoBuilder->build(Arr::get($this->config, 'collections.' . $collection . '.info', []));
        $servers = $this->serverBuilder->build(Arr::get($this->config, 'collections.' . $collection . '.servers', []));
        $tags = $this->tagBuilder->build(Arr::get($this->config, 'collections.' . $collection . '.tags', []));
        $paths = $this->pathBuilder->build($collection, Arr::get($middlewares, 'paths', []));
        $components = $this->componentBuilder->build($collection, Arr::get($middlewares, 'components', []));
        $extensions = Arr::get($this->config, 'collections.' . $collection . '.extensions', []);
        $security = Arr::get($this->config, 'collections.' . $collection . '.security', []);

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
}
