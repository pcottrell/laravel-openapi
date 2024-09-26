<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\Schemes;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\Enums\ApiKeyLocation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security\SecurityScheme;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

final readonly class ApiKey extends SecurityScheme
{
    private function __construct(
        public string $name,
        public ApiKeyLocation $in,
        string|null $description = null,
    ) {
        parent::__construct('apiKey', $description);
    }

    public static function create(string $name, ApiKeyLocation $in, string|null $description = null): self
    {
        return new self($name, $in, $description);
    }

    protected function toArray(): array
    {
        return Arr::filter([
            'type' => $this->type,
            'description' => $this->description,
            'name' => $this->name,
            'in' => $this->in->value,
        ]);
    }
}
