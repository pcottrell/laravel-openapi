<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Contracts\SchemaContract;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

/**
 * @property Schema[]|null $schemas
 * @property Response[]|null $responses
 * @property Parameter[]|null $parameters
 * @property Example[]|null $examples
 * @property RequestBody[]|null $requestBodies
 * @property Header[]|null $headers
 * @property SecurityScheme[]|null $securitySchemes
 * @property Link[]|null $links
 */
class Components extends BaseObject
{
    /**
     * @var Schema[]|null
     */
    protected $schemas;

    /**
     * @var Response[]|null
     */
    protected $responses;

    /**
     * @var Parameter[]|null
     */
    protected $parameters;

    /**
     * @var Example[]|null
     */
    protected $examples;

    /**
     * @var RequestBody[]|null
     */
    protected $requestBodies;

    /**
     * @var Header[]|null
     */
    protected $headers;

    /**
     * @var SecurityScheme[]|null
     */
    protected $securitySchemes;

    /**
     * @var Link[]|null
     */
    protected $links;

    /**
     * @var PathItem[]|null
     */
    protected $callbacks;

    /**
     * @param SchemaContract[] $schemas
     *
     * @return static
     */
    public function schemas(SchemaContract ...$schemas): self
    {
        $instance = clone $this;

        $instance->schemas = $schemas ?: null;

        return $instance;
    }

    /**
     * @param Response[] $responses
     *
     * @return static
     */
    public function responses(Response ...$responses): self
    {
        $instance = clone $this;

        $instance->responses = $responses ?: null;

        return $instance;
    }

    /**
     * @param Parameter[] $parameters
     *
     * @return static
     */
    public function parameters(Parameter ...$parameters): self
    {
        $instance = clone $this;

        $instance->parameters = $parameters ?: null;

        return $instance;
    }

    /**
     * @param Example[] $examples
     *
     * @return static
     */
    public function examples(Example ...$examples): self
    {
        $instance = clone $this;

        $instance->examples = $examples ?: null;

        return $instance;
    }

    /**
     * @param RequestBody[] $requestBodies
     *
     * @return static
     */
    public function requestBodies(RequestBody ...$requestBodies): self
    {
        $instance = clone $this;

        $instance->requestBodies = $requestBodies ?: null;

        return $instance;
    }

    /**
     * @param Header[] $headers
     *
     * @return static
     */
    public function headers(Header ...$headers): self
    {
        $instance = clone $this;

        $instance->headers = $headers ?: null;

        return $instance;
    }

    /**
     * @param SecurityScheme[] $securitySchemes
     *
     * @return static
     */
    public function securitySchemes(SecurityScheme ...$securitySchemes): self
    {
        $instance = clone $this;

        $instance->securitySchemes = $securitySchemes ?: null;

        return $instance;
    }

    /**
     * @param Link[] $links
     *
     * @return static
     */
    public function links(Link ...$links): self
    {
        $instance = clone $this;

        $instance->links = $links ?: null;

        return $instance;
    }

    /**
     * @param PathItem[] $callbacks
     *
     * @return static
     */
    public function callbacks(PathItem ...$callbacks): self
    {
        $instance = clone $this;

        $instance->callbacks = $callbacks ?: null;

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
            'schemas' => $schemas ?: null,
            'responses' => $responses ?: null,
            'parameters' => $parameters ?: null,
            'examples' => $examples ?: null,
            'requestBodies' => $requestBodies ?: null,
            'headers' => $headers ?: null,
            'securitySchemes' => $securitySchemes ?: null,
            'links' => $links ?: null,
            'callbacks' => $callbacks ?: null,
        ]);
    }
}
