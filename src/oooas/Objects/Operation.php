<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Operation extends BaseObject
{
    public const ACTION_GET = 'get';
    public const ACTION_PUT = 'put';
    public const ACTION_POST = 'post';
    public const ACTION_DELETE = 'delete';
    public const ACTION_OPTIONS = 'options';
    public const ACTION_HEAD = 'head';
    public const ACTION_PATCH = 'patch';
    public const ACTION_TRACE = 'trace';

    protected string|null $action = null;

    /** @var string[]|null */
    protected array|null $tags = null;

    protected string|null $summary = null;
    protected string|null $description = null;
    protected ExternalDocs|null $externalDocs = null;
    protected string|null $operationId = null;

    /** @var Parameter[]|null */
    protected array|null $parameters = null;

    protected RequestBody|null $requestBody = null;

    /** @var Response[]|null */
    protected array|null $responses = null;

    protected bool|null $deprecated = null;

    /** @var SecurityRequirement|SecurityRequirement[]|null */
    protected SecurityRequirement|array|null $security = null;

    protected bool|null $noSecurity = null;

    /** @var Server[]|null */
    protected array|null $servers = null;

    /** @var PathItem[]|null */
    protected array|null $callbacks = null;

    public static function get(string|null $objectId = null): static
    {
        return static::create($objectId)->action(static::ACTION_GET);
    }

    public function action(string|null $action): static
    {
        $instance = clone $this;

        $instance->action = $action;

        return $instance;
    }

    public static function put(string|null $objectId = null): static
    {
        return static::create($objectId)->action(static::ACTION_PUT);
    }

    public static function post(string|null $objectId = null): static
    {
        return static::create($objectId)->action(static::ACTION_POST);
    }

    public static function delete(string|null $objectId = null): static
    {
        return static::create($objectId)->action(static::ACTION_DELETE);
    }

    public static function options(string|null $objectId = null): static
    {
        return static::create($objectId)->action(static::ACTION_OPTIONS);
    }

    public static function head(string|null $objectId = null): static
    {
        return static::create($objectId)->action(static::ACTION_HEAD);
    }

    public static function patch(string|null $objectId = null): static
    {
        return static::create($objectId)->action(static::ACTION_PATCH);
    }

    public static function trace(string|null $objectId = null): static
    {
        return static::create($objectId)->action(static::ACTION_TRACE);
    }

    public function tags(Tag|string ...$tags): static
    {
        $allStringTags = array_map(static function ($tag) {
            if ($tag instanceof Tag) {
                return (string) $tag;
            }

            return $tag;
        }, $tags);

        $instance = clone $this;

        $instance->tags = [] !== $allStringTags ? $allStringTags : null;

        return $instance;
    }

    public function summary(string|null $summary): static
    {
        $instance = clone $this;

        $instance->summary = $summary;

        return $instance;
    }

    public function description(string|null $description): static
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    public function externalDocs(ExternalDocs|null $externalDocs): static
    {
        $instance = clone $this;

        $instance->externalDocs = $externalDocs;

        return $instance;
    }

    public function operationId(string|null $operationId): static
    {
        $instance = clone $this;

        $instance->operationId = $operationId;

        return $instance;
    }

    public function parameters(Parameter ...$parameter): static
    {
        $instance = clone $this;

        $instance->parameters = [] !== $parameter ? $parameter : null;

        return $instance;
    }

    public function requestBody(RequestBody|null $requestBody): static
    {
        $instance = clone $this;

        $instance->requestBody = $requestBody;

        return $instance;
    }

    public function responses(Response ...$response): static
    {
        $instance = clone $this;

        $instance->responses = $response;

        return $instance;
    }

    public function deprecated(bool|null $deprecated = true): static
    {
        $instance = clone $this;

        $instance->deprecated = $deprecated;

        return $instance;
    }

    public function security(SecurityRequirement ...$securityRequirement): static
    {
        $instance = clone $this;

        $instance->security = [] !== $securityRequirement ? $securityRequirement : null;
        $instance->noSecurity = null;

        return $instance;
    }

    public function noSecurity(bool|null $noSecurity = true): static
    {
        $instance = clone $this;

        $instance->noSecurity = $noSecurity;

        return $instance;
    }

    public function servers(Server ...$server): static
    {
        $instance = clone $this;

        $instance->servers = [] !== $server ? $server : null;

        return $instance;
    }

    public function callbacks(PathItem ...$pathItem): static
    {
        $instance = clone $this;

        $instance->callbacks = [] !== $pathItem ? $pathItem : null;

        return $instance;
    }

    protected function generate(): array
    {
        $responses = [];
        foreach ($this->responses ?? [] as $response) {
            $responses[$response->statusCode ?? 'default'] = $response;
        }

        $callbacks = [];
        foreach ($this->callbacks ?? [] as $callback) {
            $callbacks[$callback->objectId][$callback->route] = $callback;
        }

        return Arr::filter([
            'tags' => $this->tags,
            'summary' => $this->summary,
            'description' => $this->description,
            'externalDocs' => $this->externalDocs,
            'operationId' => $this->operationId,
            'parameters' => $this->parameters,
            'requestBody' => $this->requestBody,
            'responses' => [] !== $responses ? $responses : null,
            'deprecated' => $this->deprecated,
            'security' => $this->noSecurity ? [] : $this->security,
            'servers' => $this->servers,
            'callbacks' => [] !== $callbacks ? $callbacks : null,
        ]);
    }
}
