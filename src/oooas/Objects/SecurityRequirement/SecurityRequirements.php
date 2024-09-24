<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Objects\SecurityRequirement;

use MohammadAlavi\LaravelOpenApi\oooas\Objects\SecurityRequirement;

class SecurityRequirements
{
    private array $requirements = [];

    public static function create(): self
    {
        return new self();
    }

    public function requireAll(SecurityRequirement $requirement): self
    {
        $this->requirements[] = $requirement->toArray();

        return $this;
    }

    public function requireAny(SecurityRequirement ...$requirements): self
    {
        foreach ($requirements as $requirement) {
            $this->requirements[] = $requirement->toArray();
        }

        return $this;
    }

    public function toArray(): array
    {
        return $this->requirements;
    }
}
