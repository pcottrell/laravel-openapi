<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

/** @see https://swagger.io/specification/#security-scheme-object */
class SecurityScheme extends BaseObject
{
    public const TYPE_API_KEY = 'apiKey';
    public const TYPE_HTTP = 'http';
    public const TYPE_OAUTH2 = 'oauth2';
    public const TYPE_OPEN_ID_CONNECT = 'openIdConnect';

    // TODO: missing TYPE_MUTUAL_TLS
    public const IN_QUERY = 'query';
    public const IN_HEADER = 'header';
    public const IN_COOKIE = 'cookie';

    protected string|null $type = null;
    protected string|null $description = null;
    protected string|null $name = null;
    protected string|null $in = null;
    protected string|null $scheme = null;
    protected string|null $bearerFormat = null;

    /** @var OAuthFlow[]|null */
    protected array|null $flows = null;

    protected string|null $openIdConnectUrl = null;

    public static function oauth2(string|null $objectId = null): static
    {
        return static::create($objectId)->type(static::TYPE_OAUTH2);
    }

    public function type(string|null $type): static
    {
        $instance = clone $this;

        $instance->type = $type;

        return $instance;
    }

    public function description(string|null $description): static
    {
        $instance = clone $this;

        $instance->description = $description;

        return $instance;
    }

    // TODO: is only required when type is apiKey
    public function name(string|null $name): static
    {
        $instance = clone $this;

        $instance->name = $name;

        return $instance;
    }

    // TODO: is only required when type is apiKey
    public function in(string|null $in): static
    {
        $instance = clone $this;

        $instance->in = $in;

        return $instance;
    }

    // TODO: only required for http type and should be limited to some standard values
    // https://www.iana.org/assignments/http-authschemes/http-authschemes.xhtml
    public function scheme(string|null $scheme): static
    {
        $instance = clone $this;

        $instance->scheme = $scheme;

        return $instance;
    }

    // TODO: is only required when type is http with 'bearer' scheme
    public function bearerFormat(string|null $bearerFormat): static
    {
        $instance = clone $this;

        $instance->bearerFormat = $bearerFormat;

        return $instance;
    }

    public function flows(OAuthFlow ...$oAuthFlow): static
    {
        $instance = clone $this;

        $instance->flows = $oAuthFlow;

        return $instance;
    }

    public function openIdConnectUrl(string|null $openIdConnectUrl): static
    {
        $instance = clone $this;

        $instance->openIdConnectUrl = $openIdConnectUrl;

        return $instance;
    }

    protected function generate(): array
    {
        $flows = [];
        foreach ($this->flows ?? [] as $flow) {
            $flows[$flow->flow] = $flow;
        }

        return Arr::filter([
            'type' => $this->type,
            'description' => $this->description,
            'name' => $this->name,
            'in' => $this->in,
            'scheme' => $this->scheme,
            'bearerFormat' => $this->bearerFormat,
            'flows' => [] !== $flows ? $flows : null,
            'openIdConnectUrl' => $this->openIdConnectUrl,
        ]);
    }
}
