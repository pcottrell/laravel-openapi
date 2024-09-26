<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security;

abstract readonly class SecurityScheme implements \JsonSerializable
{
    protected function __construct(
        public string $type,
        public string|null $description = null,
    ) {
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    abstract protected function toArray(): array;
}
