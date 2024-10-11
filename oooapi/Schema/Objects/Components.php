<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableCallbackFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableParameterFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableRequestBodyFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableResponseFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableSchemaFactory;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\SimpleCreator;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\SimpleCreatorTrait;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

class Components extends ExtensibleObject implements SimpleCreator
{
    use SimpleCreatorTrait;

    /** @var ReusableSchemaFactory[]|null */
    protected array|null $schemas = null;

    /** @var ReusableResponseFactory[]|null */
    protected array|null $responses = null;

    /** @var ReusableParameterFactory[]|null */
    protected array|null $parameters = null;

    /** @var Example[]|null */
    protected array|null $examples = null;

    /** @var ReusableRequestBodyFactory[]|null */
    protected array|null $requestBodies = null;

    /** @var Header[]|null */
    protected array|null $headers = null;

    /** @var SecuritySchemeFactory[]|null */
    protected array|null $securitySchemes = null;

    /** @var Link[]|null */
    protected array|null $links = null;

    /** @var ReusableCallbackFactory[]|null */
    protected array|null $callbacks = null;

    public function schemas(ReusableSchemaFactory ...$schemaContract): static
    {
        $clone = clone $this;

        $clone->schemas = [] !== $schemaContract ? $schemaContract : null;

        return $clone;
    }

    public function responses(ReusableResponseFactory ...$response): static
    {
        $clone = clone $this;

        $clone->responses = $response;

        return $clone;
    }

    public function parameters(ReusableParameterFactory ...$parameter): static
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

    public function requestBodies(ReusableRequestBodyFactory ...$requestBody): static
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

    public function securitySchemes(SecuritySchemeFactory ...$securityScheme): static
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

    public function callbacks(ReusableCallbackFactory ...$pathItem): static
    {
        $clone = clone $this;

        $clone->callbacks = [] !== $pathItem ? $pathItem : null;

        return $clone;
    }

    protected function toArray(): array
    {
        $schemas = [];
        foreach ($this->schemas ?? [] as $schema) {
            $schemas[$schema::key()] = $schema->build();
        }

        $responses = [];
        foreach ($this->responses ?? [] as $response) {
            $responses[$response::key()] = $response->build();
        }

        $parameters = [];
        foreach ($this->parameters ?? [] as $parameter) {
            $parameters[$parameter::key()] = $parameter->build();
        }

        $examples = [];
        foreach ($this->examples ?? [] as $example) {
            $examples[$example->key()] = $example;
        }

        $requestBodies = [];
        foreach ($this->requestBodies ?? [] as $requestBody) {
            $requestBodies[$requestBody::key()] = $requestBody->build();
        }

        $headers = [];
        foreach ($this->headers ?? [] as $header) {
            $headers[$header->key()] = $header;
        }

        $securitySchemes = [];
        foreach ($this->securitySchemes ?? [] as $securityScheme) {
            $securitySchemes[$securityScheme::key()] = $securityScheme->build();
        }

        $links = [];
        foreach ($this->links ?? [] as $link) {
            $links[$link->key()] = $link;
        }

        $callbacks = [];
        foreach ($this->callbacks ?? [] as $callback) {
            $pathItem = $callback->build();
            $callbacks[$callback::key()][$pathItem->expression] = $pathItem;
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
