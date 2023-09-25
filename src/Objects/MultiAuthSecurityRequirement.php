<?php

namespace Vyuldashev\LaravelOpenApi\Objects;

use Exception;
use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\CircularDependencyException;
use Illuminate\Support\Collection;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

class MultiAuthSecurityRequirement extends SecurityRequirement
{
    private function __construct(public array $securitySchemeFactories)
    {
        $this->securityScheme = 'MultiAuth';
        parent::__construct('MultiAuth');
    }

    /**
     * @param SecuritySchemeFactory[] $securitySchemeFactory
     */
    public static function createWith(array $securitySchemeFactory): static
    {
        return new static($securitySchemeFactory);
    }

    // TODO: skip generating if empty
    public function generate(): array
    {
        return $this->createSecurityRequirements()->map(
            static fn (Collection $securityRequirement) => $securityRequirement->map(
                static fn (SecurityRequirement $securityRequirement): array => $securityRequirement->generate()[0]
            )->collapse()->toArray()
        )->toArray();
    }

    public function createSecurityRequirements(): Collection
    {
        // TODO: cannot use NoSecurity while providing multiple other securities
        // iterate over all $this->securitySchemeFactories items and check if any of them are NoSecurity
        // throw new \Exception('Cannot disable security while providing multiple other securities');
        return collect($this->securitySchemeFactories)
            // if item is a string, then we have to AND the security items
            // if item is an array, then we have to OR the security items
            ->map(function ($securityItem) {
                if (is_string($securityItem)) {
                    $scheme = $this->buildSecurityScheme($securityItem);

                    return SecurityRequirement::create()->securityScheme($scheme);
                }

                return collect($securityItem)
                    ->map(function ($securityScheme) {
                        $scheme = $this->buildSecurityScheme($securityScheme);

                        return SecurityRequirement::create()->securityScheme($scheme);
                    });
            });
    }

    /**
     * @param class-string<SecuritySchemeFactory> $securitySchemeFactory
     *
     * @throws BindingResolutionException
     * @throws CircularDependencyException
     */
    public function buildSecurityScheme(string $securitySchemeFactory): SecurityScheme
    {
        assert(class_exists($securitySchemeFactory), new Exception('Security scheme factory does not exist'));

        return app($securitySchemeFactory)->build();
    }
}
