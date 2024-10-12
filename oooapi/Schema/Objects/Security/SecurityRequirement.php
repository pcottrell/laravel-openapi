<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\JsonSerializable;

final class SecurityRequirement extends JsonSerializable
{
    // TODO: validate that the security schemes names
    // are defined in the components section
    private array $securitySchemeFactory;

    private function __construct(
        SecuritySchemeFactory ...$securitySchemeFactory,
    ) {
        $this->securitySchemeFactory = $securitySchemeFactory;
    }

    public static function create(SecuritySchemeFactory ...$securitySchemeFactory): self
    {
        return new self(...$securitySchemeFactory);
    }

    protected function toArray(): array
    {
        $securityRequirements = [];

        foreach ($this->securitySchemeFactory as $factory) {
            $securityRequirements[$factory::key()] = $factory->build();
        }

        return Arr::filter($securityRequirements);
    }
}
