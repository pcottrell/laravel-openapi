<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Enums\ApiKeyLocation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Enums\SecuritySchemeType;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityScheme;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;

final readonly class ApiKey extends SecurityScheme
{
    private function __construct(
        private string $name,
        private ApiKeyLocation $apiKeyLocation,
        string|null $description,
    ) {
        parent::__construct(SecuritySchemeType::API_KEY, $description);
    }

    public static function create(
        string $name,
        ApiKeyLocation $apiKeyLocation,
        string|null $description = null,
    ): self {
        return new self($name, $apiKeyLocation, $description);
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'type' => $this->type,
            'description' => $this->description,
            'name' => $this->name,
            'in' => $this->apiKeyLocation->value,
        ]);
    }
}
