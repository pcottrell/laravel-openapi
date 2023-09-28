<?php

namespace Vyuldashev\LaravelOpenApi\Builders;

use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use RuntimeException;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;
use Vyuldashev\LaravelOpenApi\Objects\MultiAuthSecurityRequirement;
use Vyuldashev\LaravelOpenApi\Objects\SecurityRequirement;
use Vyuldashev\LaravelOpenApi\SecuritySchemes\DefaultSecurityScheme;
use Vyuldashev\LaravelOpenApi\SecuritySchemes\PublicSecurityScheme;

class SecurityRequirementBuilder
{
    /**
     * @throws InvalidArgumentException
     */
    public function build(string|array|null $security): SecurityRequirement
    {
        if (is_null($security) || $security === '') {
            return $this->createSingleSecurityRequirement(DefaultSecurityScheme::class);
        }

        if ($security === []) {
            return $this->createSingleSecurityRequirement(PublicSecurityScheme::class);
        }

        if ($this->isSingleAuthStringSecurity($security)) {
            return $this->createSingleSecurityRequirement($security);
        }

        if ($this->isSingleAuthArraySecurity($security)) {
            if ($this->hasSingleArraySecurityWithin($security)) {
                return $this->createSingleSecurityRequirement($security[0][0]);
            }

            return $this->createSingleSecurityRequirement($security[0]);
        }

        if ($this->isMultiAuthArraySecurity($security)) {
            return MultiAuthSecurityRequirement::createWith($security);
        }

        if ($this->isMultiAuthArraySecurity($security[0])) {
            return MultiAuthSecurityRequirement::createWith($security);
        }

        throw new RuntimeException('Invalid security configuration');
    }

    /**
     * @param class-string<SecuritySchemeFactory> $securitySchemeFactory
     *
     * @throws InvalidArgumentException
     */
    private function createSingleSecurityRequirement(string $securitySchemeFactory): SecurityRequirement
    {
        /** @var SecuritySchemeFactory $security */
        $security = app($securitySchemeFactory);
        $securityScheme = $security->build();

        return SecurityRequirement::create()->securityScheme($securityScheme);
    }

    private function isSingleAuthStringSecurity(array|string|null $security): bool
    {
        return is_string($security);
    }

    private function isSingleAuthArraySecurity(array|string|null $security): bool
    {
        return !$this->isSingleAuthStringSecurity($security)
            && is_countable($security)
            && count($security) === 1
            && (is_string($security[0]) || $this->hasSingleArraySecurityWithin($security));
    }

    private function hasSingleArraySecurityWithin(array|string|null $value): bool
    {
        return is_array($value[0]) && count($value[0]) === 1 && is_string($value[0][0]);
    }

    private function isMultiAuthArraySecurity(array|string|null $security): bool
    {
        return !$this->isSingleAuthArraySecurity($security)
            && is_countable($security)
            && count($security) > 1;
    }
}
