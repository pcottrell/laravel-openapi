<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\ReadonlyJsonSerializable;

final readonly class Scopes extends ReadonlyJsonSerializable
{
    private array $scopes;

    private function __construct(Scope ...$scope)
    {
        $this->scopes = $scope;
    }

    public static function create(ScopeFactory ...$scopeFactory): self
    {
        $scopes = array_map(static fn (ScopeFactory $factory) => $factory->build(), $scopeFactory);

        return new self(...$scopes);
    }

    public function containsAll(Scope ...$scope): bool
    {
        return collect($scope)
            ->every(fn (Scope $scope) => $this->contains($scope));
    }

    public function contains(Scope $scope): bool
    {
        foreach ($this->scopes as $currentScope) {
            if (true === $currentScope->equals($scope)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get all scopes.
     */
    public function all(): array
    {
        return $this->scopes;
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
