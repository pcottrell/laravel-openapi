<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Security;

// TODO: I think this might need to extend ExtensibleObject
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
