<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

final readonly class Scope
{
    private function __construct(
        public string $name,
        public string $description,
    ) {
    }

    public static function create(string $name, string $description): self
    {
        return new self($name, $description);
    }
}
