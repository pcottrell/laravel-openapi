<?php

namespace MohammadAlavi\LaravelOpenApi\Builders;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityRequirement;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\DefaultSecurityScheme;
use MohammadAlavi\LaravelOpenApi\SecuritySchemes\NoSecurityScheme;

class SecurityRequirementBuilder
{
    /** @param class-string<SecuritySchemeFactory>|class-string<SecuritySchemeFactory>[]|null $factories */
    public function build(array|string|null $factories): SecurityRequirement
    {
        if (is_null($factories) || '' === $factories) {
            return $this->buildSecurityRequirement(DefaultSecurityScheme::class);
        }

        if ([] === $factories) {
            return $this->buildSecurityRequirement(NoSecurityScheme::class);
        }

        if ($this->isValidSecurityFactory($factories)) {
            return $this->buildSecurityRequirement($factories);
        }

        if ($this->isSingleElementArray($factories)) {
            if ($this->hasSingleElementArrayWithin($factories)) {
                return $this->buildSecurityRequirement($factories[0][0]);
            }

            return $this->buildSecurityRequirement($factories[0]);
        }

        if ($this->isMultiElementArray($factories) || $this->isMultiElementArray($factories[0])) {
            return $this->buildNestedSecurityRequirement($factories);
        }

        throw new \RuntimeException('Invalid security configuration');
    }

    private function buildSecurityRequirement(string $factory): SecurityRequirement
    {
        return SecurityRequirement::create()
            ->securityScheme(
                $this->buildSecurityScheme($factory),
            );
    }

    /** @param class-string<SecuritySchemeFactory> $factory */
    private function buildSecurityScheme(string $factory): SecurityScheme|string
    {
        return class_basename($factory);
    }

    private function isValidSecurityFactory(array|string|null $factory): bool
    {
        return is_string($factory) && is_a($factory, SecuritySchemeFactory::class, true);
    }

    private function isSingleElementArray(array|string|null $factories): bool
    {
        return !$this->isValidSecurityFactory($factories)
            && is_array($factories)
            && 1 === count($factories)
            && ($this->isValidSecurityFactory($factories[0]) || $this->hasSingleElementArrayWithin($factories));
    }

    private function hasSingleElementArrayWithin(array|string|null $value): bool
    {
        return is_array($value[0]) && $this->isSingleElementArray($value[0]);
    }

    private function isMultiElementArray(array|string|null $factories): bool
    {
        return !$this->isSingleElementArray($factories)
            && is_array($factories)
            && count($factories) > 1;
    }

    /** @param array<array-key, class-string<SecuritySchemeFactory>|array<array-key, class-string<SecuritySchemeFactory>>> $factories */
    private function buildNestedSecurityRequirement(array $factories): SecurityRequirement
    {
        return SecurityRequirement::create()
            ->nestedSecurityScheme(
                $this->buildNestedSecurityScheme($factories),
            );
    }

    /**
     * @param array<array-key, class-string<SecuritySchemeFactory>|array<array-key, class-string<SecuritySchemeFactory>>> $factories
     *
     * @return array<array-key, SecurityScheme|array<array-key, SecurityScheme>>
     */
    private function buildNestedSecurityScheme(array $factories): array
    {
        return collect($factories)
            ->map(function (array|string|null $factory): array|SecurityScheme|string {
                if (is_array($factory) && [] !== $factory) {
                    return $this->buildNestedSecurityScheme($factory);
                }

                if ($this->isValidSecurityFactory($factory)) {
                    return $this->buildSecurityScheme($factory);
                }

                throw new \RuntimeException('Invalid security configuration');
            })->toArray();
    }
}
