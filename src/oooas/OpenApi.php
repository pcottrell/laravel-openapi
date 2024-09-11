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

/**
 * @property string|null $openapi
 * @property Info|null $info
 * @property Server[]|null $servers
 * @property PathItem[]|null $paths
 * @property Components|null $components
 * @property SecurityRequirement[]|null $security
 * @property Tag[]|null $tags
 * @property ExternalDocs|null $externalDocs
 */
class OpenApi extends BaseObject
{
    public const OPENAPI_3_0_0 = '3.0.0';
    public const OPENAPI_3_0_1 = '3.0.1';
    public const OPENAPI_3_0_2 = '3.0.2';

    protected string|null $openapi = null;
    protected Info|null $info = null;

    /**
     * @var Server[]|null
     */
    protected array|null $servers = null;

    /**
     * @var PathItem[]|null
     */
    protected array|null $paths = null;

    protected Components|null $components = null;

    /**
     * @var SecurityRequirement[]|null
     */
    protected array|null $security = null;

    /**
     * @var Tag[]|null
     */
    protected array|null $tags = null;

    protected ExternalDocs|null $externalDocs = null;

    /**
     * @return static
     */
    public function openapi(string|null $openapi): self
    {
        $instance = clone $this;

        $instance->openapi = $openapi;

        return $instance;
    }

    /**
     * @return static
     */
    public function info(Info|null $info): self
    {
        $instance = clone $this;

        $instance->info = $info;

        return $instance;
    }

    /**
     * @param Server[] $server
     *
     * @return static
     */
    public function servers(Server ...$server): self
    {
        $instance = clone $this;

        $instance->servers = [] !== $server ? $server : null;

        return $instance;
    }

    /**
     * @param PathItem[] $pathItem
     *
     * @return static
     */
    public function paths(PathItem ...$pathItem): self
    {
        $instance = clone $this;

        $instance->paths = [] !== $pathItem ? $pathItem : null;

        return $instance;
    }

    /**
     * @return static
     */
    public function components(Components|null $components): self
    {
        $instance = clone $this;

        $instance->components = $components;

        return $instance;
    }

    /**
     * @param SecurityRequirement[] $securityRequirement
     *
     * @return static
     */
    public function security(SecurityRequirement ...$securityRequirement): self
    {
        $instance = clone $this;

        $instance->security = [] !== $securityRequirement ? $securityRequirement : null;

        return $instance;
    }

    /**
     * @param Tag[] $tag
     *
     * @return static
     */
    public function tags(Tag ...$tag): self
    {
        $instance = clone $this;

        $instance->tags = [] !== $tag ? $tag : null;

        return $instance;
    }

    /**
     * @return static
     */
    public function externalDocs(ExternalDocs|null $externalDocs): self
    {
        $instance = clone $this;

        $instance->externalDocs = $externalDocs;

        return $instance;
    }

    /**
     * @throws ValidationException
     */
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
