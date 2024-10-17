<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Scope;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\ReadonlyGenerator;

final readonly class SecurityRequirement extends ReadonlyGenerator
{
    private array $requirements;

    private function __construct(
        Requirement ...$requirement,
    ) {
        $this->requirements = $requirement;
    }

    public static function create(Requirement ...$requirement): self
    {
        return new self(...$requirement);
    }

    protected function toArray(): array
    {
        $securityRequirements = [];
        foreach ($this->requirements as $requirement) {
            $securityRequirements[$requirement->securityScheme()] = array_map(
                static fn (Scope $scope): string => $scope->name(),
                $requirement->scopes(),
            );
        }

        return Arr::filter($securityRequirements);
    }
}
