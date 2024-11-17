<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Enums\SecuritySchemeType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityScheme;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final readonly class MutualTLS extends SecurityScheme
{
    private function __construct(
        string|null $description,
    ) {
        parent::__construct(SecuritySchemeType::MUTUAL_TLS, $description);
    }

    public static function create(string|null $description = null): self
    {
        return new self($description);
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'type' => $this->securitySchemeType,
            'description' => $this->description,
        ]);
    }
}
