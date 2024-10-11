<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security;

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\JsonSerializable;

final class Security extends JsonSerializable
{
    private array $securityRequirements;

    private function __construct(
        SecurityRequirement ...$securityRequirement,
    ) {
        $this->securityRequirements = $securityRequirement;
    }

    public function merge(self $security): self
    {
        return self::create(
            ...$this->securityRequirements,
            ...$security->securityRequirements,
        );
    }

    public static function create(SecurityRequirement ...$securityRequirement): self
    {
        return new self(...$securityRequirement);
    }

    public function requireAll(SecurityRequirement ...$securityRequirement): self
    {
        $clone = clone $this;

        $clone->securityRequirements = $securityRequirement;

        return $clone;
    }

    public function requireAny(SecurityRequirement ...$securityRequirement): self
    {
        foreach ($securityRequirement as $requirement) {
            $this->securityRequirements[] = $requirement;
        }

        return $this;
    }

    public function toArray(): array
    {
        return $this->securityRequirements;
    }
}
