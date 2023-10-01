<?php

namespace Vyuldashev\LaravelOpenApi\Builders;

use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use RuntimeException;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;
use Vyuldashev\LaravelOpenApi\Objects\SecurityRequirement;
use Vyuldashev\LaravelOpenApi\SecuritySchemes\DefaultSecurityScheme;
use Vyuldashev\LaravelOpenApi\SecuritySchemes\PublicSecurityScheme;

class SecurityRequirementBuilder
{
    /**
     * @throws InvalidArgumentException
     */
    public function build(string|array|null $securitySchemeFactories): SecurityRequirement
    {
        if (is_null($securitySchemeFactories) || $securitySchemeFactories === '') {
            return $this->createSingleSecurityRequirement(DefaultSecurityScheme::class);
        }

        if ($securitySchemeFactories === []) {
            return $this->createSingleSecurityRequirement(PublicSecurityScheme::class);
        }

        if ($this->isSingleAuthStringSecurity($securitySchemeFactories)) {
            return $this->createSingleSecurityRequirement($securitySchemeFactories);
        }

        if ($this->isSingleAuthArraySecurity($securitySchemeFactories)) {
            if ($this->hasSingleArraySecurityWithin($securitySchemeFactories)) {
                return $this->createSingleSecurityRequirement($securitySchemeFactories[0][0]);
            }

            return $this->createSingleSecurityRequirement($securitySchemeFactories[0]);
        }

        if ($this->isMultiAuthArraySecurity($securitySchemeFactories)) {
            return SecurityRequirement::create()->multiAuthSecurityScheme($securitySchemeFactories);
        }

        if ($this->isMultiAuthArraySecurity($securitySchemeFactories[0])) {
            return SecurityRequirement::create()->multiAuthSecurityScheme($securitySchemeFactories);
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
