<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Objects\Security;

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

    abstract public function toArray(): array;
}
