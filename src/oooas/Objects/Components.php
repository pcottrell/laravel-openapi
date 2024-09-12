<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class Components extends BaseObject
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
        $instance = clone $this;

        $instance->schemas = [] !== $schemaContract ? $schemaContract : null;

        return $instance;
    }

    public function responses(Response ...$response): static
    {
        $instance = clone $this;

        $instance->responses = [] !== $response ? $response : null;

        return $instance;
    }

    public function parameters(Parameter ...$parameter): static
    {
        $instance = clone $this;

        $instance->parameters = [] !== $parameter ? $parameter : null;

        return $instance;
    }

    public function examples(Example ...$example): static
    {
        $instance = clone $this;

        $instance->examples = [] !== $example ? $example : null;

        return $instance;
    }

    public function requestBodies(RequestBody ...$requestBody): static
    {
        $instance = clone $this;

        $instance->requestBodies = [] !== $requestBody ? $requestBody : null;

        return $instance;
    }

    public function headers(Header ...$header): static
    {
        $instance = clone $this;

        $instance->headers = [] !== $header ? $header : null;

        return $instance;
    }

    public function securitySchemes(SecurityScheme ...$securityScheme): static
    {
        $instance = clone $this;

        $instance->securitySchemes = [] !== $securityScheme ? $securityScheme : null;

        return $instance;
    }

    public function links(Link ...$link): static
    {
        $instance = clone $this;

        $instance->links = [] !== $link ? $link : null;

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
        foreach ($this->requestBodies ?? [] as $requestBodie) {
            $requestBodies[$requestBodie->objectId] = $requestBodie;
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
