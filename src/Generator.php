<?php

namespace Vyuldashev\LaravelOpenApi;

use Illuminate\Support\Arr;
use Vyuldashev\LaravelOpenApi\Builders\ComponentBuilder;
use Vyuldashev\LaravelOpenApi\Builders\InfoBuilder;
use Vyuldashev\LaravelOpenApi\Builders\PathBuilder;
use Vyuldashev\LaravelOpenApi\Builders\ServerBuilder;
use Vyuldashev\LaravelOpenApi\Builders\TagBuilder;
use Vyuldashev\LaravelOpenApi\Objects\OpenApi;

class Generator
{
    public string $version = OpenApi::OPENAPI_3_0_2;
    public const COLLECTION_DEFAULT = 'default';

    public function __construct(
        protected array $config,
        protected InfoBuilder $infoBuilder,
        protected ServerBuilder $serverBuilder,
        protected TagBuilder $tagBuilder,
        protected PathBuilder $pathBuilder,
        protected ComponentBuilder $componentBuilder,
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

        $openApi = OpenApi::create()
            ->openapi(OpenApi::OPENAPI_3_0_2)
            ->info($info)
            ->servers(...$servers)
            ->paths(...$paths)
            ->components($components)
            ->multiAuthSecurity(Arr::get($this->config, 'collections.' . $collection . '.security', []))
            ->tags(...$tags);

        foreach ($extensions as $key => $value) {
            $openApi = $openApi->x($key, $value);
        }

        return $openApi;
    }
}
