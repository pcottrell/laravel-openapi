<?php

namespace MohammadAlavi\LaravelOpenApi\Builders;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityRequirementOld;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\SecurityScheme;

class SecurityRequirementBuilder
{
    private const REMOVE_TOP_LEVEL_SECURITY = [];
    private const USE_TOP_LEVEL_SECURITY = null;

    /** @param class-string<SecuritySchemeFactory>|class-string<SecuritySchemeFactory>[]|null $factories */
    public function build(array|string|null $factories): SecurityRequirementOld
    {
        if (!$this->isValidSecurityScheme($factories)) {
            throw new \InvalidArgumentException(sprintf('Security class is either not declared or is not an instance of %s.', SecuritySchemeFactory::class));
        }

//        if (is_null($factories) || '' === $factories) {
//            return $this->buildSecurityRequirement(DefaultSecurityScheme::class);
//        }

//        if ([] === $factories) {
//            return $this->buildSecurityRequirement(NoSecurityScheme::class);
//        }

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

    private function isValidSecurityScheme(string|array|null $security): bool
    {
        if (self::REMOVE_TOP_LEVEL_SECURITY === $security || self::USE_TOP_LEVEL_SECURITY === $security) {
            return true;
        }

        if (is_string($security)) {
            return $this->isValidSingleSecurityScheme($security);
        }

        return $this->isValidMultiSecurityScheme($security);
    }

    private function isValidSingleSecurityScheme(string|null $securityScheme): bool
    {
        return !is_null($securityScheme)
            && '' !== $securityScheme
            && class_exists($securityScheme)
            && is_a(
                $securityScheme,
                SecuritySchemeFactory::class,
                true,
            );
    }

    private function isValidMultiSecurityScheme(array $securities): bool
    {
        $isValid = true;
        foreach ($securities as $security) {
            if (is_array($security)) {
                if ([] === $security) {
                    return false;
                }

                return $this->isValidMultiSecurityScheme($security);
            }

            $isValid = $isValid && $this->isValidSingleSecurityScheme($security);
        }

        return $isValid;
    }

    private function buildSecurityRequirement(string $factory): SecurityRequirementOld
    {
        return SecurityRequirementOld::create()
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
    private function buildNestedSecurityRequirement(array $factories): SecurityRequirementOld
    {
        return SecurityRequirementOld::create()
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
