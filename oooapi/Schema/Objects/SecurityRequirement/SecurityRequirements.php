<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityRequirement;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityRequirement;

final class SecurityRequirements
{
    private array $requirements = [];

    public static function create(): self
    {
        return new self();
    }

    public function requireAll(SecurityRequirement $securityRequirement): self
    {
        $this->requirements[] = $securityRequirement->jsonSerialize();

        return $this;
    }

    public function requireAny(SecurityRequirement ...$securityRequirement): self
    {
        foreach ($securityRequirement as $requirement) {
            $this->requirements[] = $requirement->jsonSerialize();
        }

        return $this;
    }

    protected function toArray(): array
    {
        return $this->requirements;
    }
}
