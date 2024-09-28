<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Components extends ExtensibleObject
{
    /** @var SchemaContract[]|null */
    protected array|null $schemas = null;

    /** @var Response[]|null */
    protected array|null $responses = null;

    /** @var Parameter[]|null */
    protected array|null $parameters = null;

    /** @var Example[]|null */
    protected array|null $examples = null;

    /** @var RequestBody[]|null */
    protected array|null $requestBodies = null;

    /** @var Header[]|null */
    protected array|null $headers = null;

    /** @var SecurityScheme[]|null */
    protected array|null $securitySchemes = null;

    /** @var Link[]|null */
    protected array|null $links = null;

    /** @var PathItem[]|null */
    protected array|null $callbacks = null;

    public function schemas(SchemaContract ...$schemaContract): static
    {
        $clone = clone $this;

        $clone->schemas = [] !== $schemaContract ? $schemaContract : null;

        return $clone;
    }

    public function responses(Response ...$response): static
    {
        $clone = clone $this;

        $clone->responses = [] !== $response ? $response : null;

        return $clone;
    }

    public function parameters(Parameter ...$parameter): static
    {
        $clone = clone $this;

        $clone->parameters = [] !== $parameter ? $parameter : null;

        return $clone;
    }

    public function examples(Example ...$example): static
    {
        $clone = clone $this;

        $clone->examples = [] !== $example ? $example : null;

        return $clone;
    }

    public function requestBodies(RequestBody ...$requestBody): static
    {
        $clone = clone $this;

        $clone->requestBodies = [] !== $requestBody ? $requestBody : null;

        return $clone;
    }

    public function headers(Header ...$header): static
    {
        $clone = clone $this;

        $clone->headers = [] !== $header ? $header : null;

        return $clone;
    }

    public function securitySchemes(SecurityScheme ...$securityScheme): static
    {
        $clone = clone $this;

        $clone->securitySchemes = [] !== $securityScheme ? $securityScheme : null;

        return $clone;
    }

    public function links(Link ...$link): static
    {
        $clone = clone $this;

        $clone->links = [] !== $link ? $link : null;

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
        $schemas = [];
        foreach ($this->schemas ?? [] as $schema) {
            $schemas[$schema->objectId] = $schema;
        }

        $responses = [];
        foreach ($this->responses ?? [] as $response) {
            $responses[$response->objectId] = $response;
        }

        $parameters = [];
        foreach ($this->parameters ?? [] as $parameter) {
            $parameters[$parameter->objectId] = $parameter;
        }

        $examples = [];
        foreach ($this->examples ?? [] as $example) {
            $examples[$example->objectId] = $example;
        }

        $requestBodies = [];
        foreach ($this->requestBodies ?? [] as $requestBody) {
            $requestBodies[$requestBody->objectId] = $requestBody;
        }

        $headers = [];
        foreach ($this->headers ?? [] as $header) {
            $headers[$header->objectId] = $header;
        }

        $securitySchemes = [];
        foreach ($this->securitySchemes ?? [] as $securityScheme) {
            $securitySchemes[$securityScheme->objectId] = $securityScheme;
        }

        $links = [];
        foreach ($this->links ?? [] as $link) {
            $links[$link->objectId] = $link;
        }

        $callbacks = [];
        foreach ($this->callbacks ?? [] as $callback) {
            $callbacks[$callback->objectId][$callback->route] = $callback;
        }

        return Arr::filter([
            'schemas' => [] !== $schemas ? $schemas : null,
            'responses' => [] !== $responses ? $responses : null,
            'parameters' => [] !== $parameters ? $parameters : null,
            'examples' => [] !== $examples ? $examples : null,
            'requestBodies' => [] !== $requestBodies ? $requestBodies : null,
            'headers' => [] !== $headers ? $headers : null,
            'securitySchemes' => [] !== $securitySchemes ? $securitySchemes : null,
            'links' => [] !== $links ? $links : null,
            'callbacks' => [] !== $callbacks ? $callbacks : null,
        ]);
    }
}
