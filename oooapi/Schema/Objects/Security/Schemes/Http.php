<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Enums\HttpScheme;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityScheme;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final readonly class Http extends SecurityScheme
{
    private function __construct(
        public HttpScheme $httpScheme,
        string|null $description = null,
        public string|null $bearerFormat = null,
    ) {
        parent::__construct('http', $description);
    }

    public static function basic(string|null $description = null): self
    {
        return new self(HttpScheme::BASIC, $description);
    }

    public static function bearer(string|null $description = null, string|null $bearerFormat = null): self
    {
        return new self(HttpScheme::BEARER, $description, $bearerFormat);
    }

    public static function digest(string|null $description = null): self
    {
        return new self(HttpScheme::DIGEST, $description);
    }

    public static function dpop(string|null $description = null): self
    {
        return new self(HttpScheme::DPOP, $description);
    }

    public static function hoba(string|null $description = null): self
    {
        return new self(HttpScheme::HOBA, $description);
    }

    public static function mutual(string|null $description = null): self
    {
        return new self(HttpScheme::MUTUAL, $description);
    }

    public static function negotiate(string|null $description = null): self
    {
        return new self(HttpScheme::NEGOTIATE, $description);
    }

    public static function oAuth(string|null $description = null): self
    {
        return new self(HttpScheme::OAUTH, $description);
    }

    public static function privateToken(string|null $description = null): self
    {
        return new self(HttpScheme::PRIVATE_TOKEN, $description);
    }

    public static function scramSha1(string|null $description = null): self
    {
        return new self(HttpScheme::SCRAM_SHA_1, $description);
    }

    public static function scramSha256(string|null $description = null): self
    {
        return new self(HttpScheme::SCRAM_SHA_256, $description);
    }

    public static function vapid(string|null $description = null): self
    {
        return new self(HttpScheme::VAPID, $description);
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'type' => $this->type,
            'description' => $this->description,
            'scheme' => $this->httpScheme->value,
            'bearerFormat' => $this->bearerFormat,
        ]);
    }
}
