<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\DefaultSecurityScheme;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\NoSecurityScheme;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Operation extends ExtensibleObject
{
    // TODO: refactor all const everywhere to enum
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
        $clone = clone $this;

        $clone->action = $action;

        return $clone;
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
        $allStringTags = array_map(static function (Tag|string $tag): string {
            if ($tag instanceof Tag) {
                return (string) $tag;
            }

            return $tag;
        }, $tags);

        $clone = clone $this;

        $clone->tags = [] !== $allStringTags ? $allStringTags : null;

        return $clone;
    }

    public function summary(string|null $summary): static
    {
        $clone = clone $this;

        $clone->summary = $summary;

        return $clone;
    }

    public function description(string|null $description): static
    {
        $clone = clone $this;

        $clone->description = $description;

        return $clone;
    }

    public function externalDocs(ExternalDocs|null $externalDocs): static
    {
        $clone = clone $this;

        $clone->externalDocs = $externalDocs;

        return $clone;
    }

    public function operationId(string|null $operationId): static
    {
        $clone = clone $this;

        $clone->operationId = $operationId;

        return $clone;
    }

    public function parameters(Parameter ...$parameter): static
    {
        $clone = clone $this;

        $clone->parameters = [] !== $parameter ? $parameter : null;

        return $clone;
    }

    public function requestBody(RequestBody|null $requestBody): static
    {
        $clone = clone $this;

        $clone->requestBody = $requestBody;

        return $clone;
    }

    public function responses(Response ...$response): static
    {
        $clone = clone $this;

        $clone->responses = $response;

        return $clone;
    }

    public function deprecated(bool|null $deprecated = true): static
    {
        $clone = clone $this;

        $clone->deprecated = $deprecated;

        return $clone;
    }

    /**
     * You should only send one security requirement per operation.
     * If you send more than one, the first one will be used.
     */
    public function security(SecurityRequirement ...$securityRequirement): static
    {
        //        $clone = clone $this;
        //
        //        $clone->security = [] !== $securityRequirement ? $securityRequirement : null;
        //        $clone->noSecurity = null;
        //
        //        return $clone;

        if ([] === $securityRequirement) {
            return $this;
        }

        $clone = clone $this;

        // true overrides "global security" = [] in the generated OpenAPI spec
        // false/null uses $security
        // we disable it and use $security to configure the security.
        $clone->noSecurity = false;

        if ($this->shouldUseGlobalSecurity($securityRequirement[0])) {
            $clone->security = null;

            return $clone;
        }

        if ($this->isPublic($securityRequirement[0])) {
            $clone->security = [];

            return $clone;
        }

        $clone->security = $securityRequirement[0];

        return $clone;
    }

    private function shouldUseGlobalSecurity(SecurityRequirement $securityRequirement): bool
    {
        return DefaultSecurityScheme::NAME === $securityRequirement->securityScheme;
    }

    private function isPublic(SecurityRequirement $securityRequirement): bool
    {
        return NoSecurityScheme::NAME === $securityRequirement->securityScheme;
    }

    public function noSecurity(): static
    {
        $clone = clone $this;

        $clone->noSecurity = true;

        return $clone;
    }

    public function servers(Server ...$server): static
    {
        $clone = clone $this;

        $clone->servers = [] !== $server ? $server : null;

        return $clone;
    }

    public function callbacks(PathItem ...$pathItem): static
    {
        $clone = clone $this;

        $clone->callbacks = [] !== $pathItem ? $pathItem : null;

        return $clone;
    }

    protected function toArray(): array
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
            'security' => true === $this->noSecurity ? [] : $this->security,
            'servers' => $this->servers,
            'callbacks' => [] !== $callbacks ? $callbacks : null,
        ]);
    }
}
