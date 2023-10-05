<?php

namespace MohammadAlavi\LaravelOpenApi;

use Illuminate\Support\Arr;
use MohammadAlavi\LaravelOpenApi\Builders\ComponentBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\InfoBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\PathBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\ServerBuilder;
use MohammadAlavi\LaravelOpenApi\Builders\TagBuilder;
use MohammadAlavi\LaravelOpenApi\Objects\OpenApi;
use Stringable;

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
        $collection = $this->getString($collection);
        $availableCollections = Arr::get($this->config, 'collections');
        $availableCollections = array_keys($availableCollections);
        $collectionMap = [];
        foreach ($availableCollections as $item) {
            $collectionMap[$this->getString($item)] = $item;
        }

        $middlewares = Arr::get($this->config, 'collections.' . $collection . '.middlewares');

        $info = $this->infoBuilder->build(Arr::get($this->config, 'collections.' . $collectionMap[$collection] . '.info', []));
        $servers = $this->serverBuilder->build(Arr::get($this->config, 'collections.' . $collectionMap[$collection] . '.servers', []));
        $tags = $this->tagBuilder->build(Arr::get($this->config, 'collections.' . $collectionMap[$collection] . '.tags', []));
        $paths = $this->pathBuilder->build($collection, Arr::get($middlewares, 'paths', []));
        $components = $this->componentBuilder->build($collection, Arr::get($middlewares, 'components', []));
        $extensions = Arr::get($this->config, 'collections.' . $collectionMap[$collection] . '.extensions', []);
        $security = Arr::get($this->config, 'collections.' . $collectionMap[$collection] . '.security', []);

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

    private function isStringable(string $name): bool
    {
        return class_exists($name) && is_subclass_of($name, Stringable::class, true);
    }

    private function getString(string $name): string
    {
        if ($this->isStringable($name)) {
            return (string) (new $name());
        }

        return $name;
    }
}
