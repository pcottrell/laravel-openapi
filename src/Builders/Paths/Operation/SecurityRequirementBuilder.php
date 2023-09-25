<?php

namespace Vyuldashev\LaravelOpenApi\Builders\Paths\Operation;

use GoldSpecDigital\ObjectOrientedOAS\Exceptions\InvalidArgumentException;
use RuntimeException;
use Vyuldashev\LaravelOpenApi\Attributes\Operation as OperationAttribute;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;
use Vyuldashev\LaravelOpenApi\Objects\MultiAuthSecurityRequirement;
use Vyuldashev\LaravelOpenApi\Objects\SecurityRequirement;
use Vyuldashev\LaravelOpenApi\RouteInformation;

class SecurityRequirementBuilder
{
    public function build(RouteInformation $route): SecurityRequirement
    {
        return $route->actionAttributes
            ->filter(static fn (object $attribute) => $attribute instanceof OperationAttribute)
            ->filter(static fn (OperationAttribute $attribute) => isset($attribute->security))
            ->map(function (OperationAttribute $attribute) {
                $securitySchemes = $attribute->security;

                if ($this->singleAuthStringSecurity($securitySchemes)) {
                    return $this->createSingleSecurityRequirement($securitySchemes);
                }

                if ($this->singleAuthArraySecurity($securitySchemes)) {
                    return $this->createSingleSecurityRequirement($securitySchemes[0]);
                }

                if ($this->multiAuthArraySecurity($securitySchemes)) {
                    return MultiAuthSecurityRequirement::createWith($securitySchemes);
                }

                throw new RuntimeException('Invalid security configuration');
            })
            ->sole();
    }

    /**
     * @param class-string<SecuritySchemeFactory> $securitySchemeFactory
     *
     * @throws InvalidArgumentException
     */
    public function createSingleSecurityRequirement(string $securitySchemeFactory): SecurityRequirement
    {
        /** @var SecuritySchemeFactory $security */
        $security = app($securitySchemeFactory);
        $securityScheme = $security->build();

        return SecurityRequirement::create()->securityScheme($securityScheme);
    }

    public function singleAuthStringSecurity(array|string|null $security): bool
    {
        return is_string($security);
    }

    public function singleAuthArraySecurity(array|string|null $security): bool
    {
        return !$this->singleAuthStringSecurity($security)
            && is_countable($security)
            && count($security) === 1
            && $security[0] instanceof SecuritySchemeFactory;
    }

    public function multiAuthArraySecurity(array|string|null $security): bool
    {
        return !$this->singleAuthArraySecurity($security)
            && is_countable($security)
            && (count($security) > 1 || is_array($security));
    }
}
