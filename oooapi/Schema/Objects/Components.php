<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\SimpleCreator;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\SchemaContract;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\SimpleCreatorTrait;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

class Components extends ExtensibleObject implements SimpleCreator
{
    use SimpleCreatorTrait;

    /** @var SchemaContract[]|null */
    protected array|null $schemas = null;

    /** @var Response[] */
    protected array $responses = [];

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

        $clone->responses = $response;

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
            $schemas[$schema->key()] = $schema;
        }

        $responses = [];
        foreach ($this->responses as $response) {
            $responses[$response->key()] = $response;
        }

        $parameters = [];
        foreach ($this->parameters ?? [] as $parameter) {
            $parameters[$parameter->key()] = $parameter;
        }

        $examples = [];
        foreach ($this->examples ?? [] as $example) {
            $examples[$example->key()] = $example;
        }

        $requestBodies = [];
        foreach ($this->requestBodies ?? [] as $requestBody) {
            $requestBodies[$requestBody->key()] = $requestBody;
        }

        $headers = [];
        foreach ($this->headers ?? [] as $header) {
            $headers[$header->key()] = $header;
        }

        $securitySchemes = [];
        foreach ($this->securitySchemes ?? [] as $securityScheme) {
            $securitySchemes[$securityScheme->key()] = $securityScheme;
        }

        $links = [];
        foreach ($this->links ?? [] as $link) {
            $links[$link->key()] = $link;
        }

        $callbacks = [];
        foreach ($this->callbacks ?? [] as $callback) {
            $callbacks[$callback->key()][$callback->path] = $callback;
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
            // TODO: add extensions
        ]);
    }
}
