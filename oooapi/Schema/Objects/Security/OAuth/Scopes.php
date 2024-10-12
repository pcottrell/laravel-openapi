<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\ReadonlyJsonSerializable;

final readonly class Scopes extends ReadonlyJsonSerializable
{
    private array $scopes;

    private function __construct(Scope ...$scopes)
    {
        $this->scopes = $scopes;
    }

    public static function create(Scope ...$scopes): self
    {
        return new self(...$scopes);
    }

    protected function toArray(): array
    {
        $scopes = array_reduce($this->scopes, static function ($carry, $scope) {
            $carry[$scope->name] = $scope->description;

            return $carry;
        }, []);

        return Arr::filter($scopes);
    }
}
