<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Contracts\Interface\SimpleKeyCreator;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\SimpleKeyCreatorTrait;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

/** @see https://swagger.io/specification/#security-scheme-object */
class SecurityScheme extends ExtensibleObject implements SimpleKeyCreator
{
    use SimpleKeyCreatorTrait;

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

    public static function oauth2(string $key): static
    {
        return static::create($key)->type(static::TYPE_OAUTH2);
    }

    public function type(string|null $type): static
    {
        $clone = clone $this;

        $clone->type = $type;

        return $clone;
    }

    public function description(string|null $description): static
    {
        $clone = clone $this;

        $clone->description = $description;

        return $clone;
    }

    // TODO: is only required when type is apiKey
    public function name(string|null $name): static
    {
        $clone = clone $this;

        $clone->name = $name;

        return $clone;
    }

    // TODO: is only required when type is apiKey
    public function in(string|null $in): static
    {
        $clone = clone $this;

        $clone->in = $in;

        return $clone;
    }

    // TODO: only required for http type and should be limited to some standard values
    // https://www.iana.org/assignments/http-authschemes/http-authschemes.xhtml
    public function scheme(string|null $scheme): static
    {
        $clone = clone $this;

        $clone->scheme = $scheme;

        return $clone;
    }

    // TODO: is only required when type is http with 'bearer' scheme
    public function bearerFormat(string|null $bearerFormat): static
    {
        $clone = clone $this;

        $clone->bearerFormat = $bearerFormat;

        return $clone;
    }

    public function flows(OAuthFlow ...$oAuthFlow): static
    {
        $clone = clone $this;

        $clone->flows = $oAuthFlow;

        return $clone;
    }

    public function openIdConnectUrl(string|null $openIdConnectUrl): static
    {
        $clone = clone $this;

        $clone->openIdConnectUrl = $openIdConnectUrl;

        return $clone;
    }

    protected function toArray(): array
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
