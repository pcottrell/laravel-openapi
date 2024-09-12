<?php

namespace MohammadAlavi\ObjectOrientedOAS;

use JsonSchema\Constraints\BaseConstraint;
use JsonSchema\Validator;
use MohammadAlavi\ObjectOrientedOAS\Exceptions\ValidationException;
use MohammadAlavi\ObjectOrientedOAS\Objects\BaseObject;
use MohammadAlavi\ObjectOrientedOAS\Objects\Components;
use MohammadAlavi\ObjectOrientedOAS\Objects\ExternalDocs;
use MohammadAlavi\ObjectOrientedOAS\Objects\Info;
use MohammadAlavi\ObjectOrientedOAS\Objects\PathItem;
use MohammadAlavi\ObjectOrientedOAS\Objects\SecurityRequirement;
use MohammadAlavi\ObjectOrientedOAS\Objects\Server;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class OpenApi extends BaseObject
{
    public const OPENAPI_3_0_0 = '3.0.0';
    public const OPENAPI_3_0_1 = '3.0.1';
    public const OPENAPI_3_0_2 = '3.0.2';

    protected string|null $openapi = null;
    protected Info|null $info = null;

    /** @var Server[]|null */
    protected array|null $servers = null;

    /** @var PathItem[]|null */
    protected array|null $paths = null;

    protected Components|null $components = null;

    /** @var SecurityRequirement|SecurityRequirement[]|null */
    protected SecurityRequirement|array|null $security = null;

    /** @var Tag[]|null */
    protected array|null $tags = null;

    protected ExternalDocs|null $externalDocs = null;

    public function openapi(string|null $openapi): static
    {
        $instance = clone $this;

        $instance->openapi = $openapi;

        return $instance;
    }

    public function info(Info|null $info): static
    {
        $instance = clone $this;

        $instance->info = $info;

        return $instance;
    }

    public function servers(Server ...$server): static
    {
        $instance = clone $this;

        $instance->servers = [] !== $server ? $server : null;

        return $instance;
    }

    public function paths(PathItem ...$pathItem): static
    {
        $instance = clone $this;

        $instance->paths = [] !== $pathItem ? $pathItem : null;

        return $instance;
    }

    public function components(Components|null $components): static
    {
        $instance = clone $this;

        $instance->components = $components;

        return $instance;
    }

    public function security(SecurityRequirement ...$securityRequirement): static
    {
        $instance = clone $this;

        $instance->security = [] !== $securityRequirement ? $securityRequirement : null;

        return $instance;
    }

    public function tags(Tag ...$tag): static
    {
        $instance = clone $this;

        $instance->tags = [] !== $tag ? $tag : null;

        return $instance;
    }

    public function externalDocs(ExternalDocs|null $externalDocs): static
    {
        $instance = clone $this;

        $instance->externalDocs = $externalDocs;

        return $instance;
    }

    /** @throws ValidationException */
    public function validate(): void
    {
        if (!class_exists(Validator::class)) {
            throw new \RuntimeException('justinrainbow/json-schema should be installed for validation');
        }

        $data = BaseConstraint::arrayToObjectRecursive($this->generate());

        $schema = file_get_contents(
            realpath(__DIR__ . '/schemas/v3.0.json'),
        );
        $schema = json_decode($schema);

        $validator = new Validator();
        $validator->validate($data, $schema);

        if (!$validator->isValid()) {
            throw new ValidationException($validator->getErrors());
        }
    }

    protected function generate(): array
    {
        $paths = [];
        foreach ($this->paths ?? [] as $path) {
            $paths[$path->route] = $path;
        }

        return Arr::filter([
            'openapi' => $this->openapi,
            'info' => $this->info,
            'servers' => $this->servers,
            'paths' => [] !== $paths ? $paths : null,
            'components' => $this->components,
            'security' => $this->security,
            'tags' => $this->tags,
            'externalDocs' => $this->externalDocs,
        ]);
    }
}
