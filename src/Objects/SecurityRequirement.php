<?php

namespace Vyuldashev\LaravelOpenApi\Objects;

use Exception;
use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityRequirement as ParentSecurityRequirement;
use GoldSpecDigital\ObjectOrientedOAS\Objects\SecurityScheme;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\CircularDependencyException;
use Illuminate\Support\Collection;
use Vyuldashev\LaravelOpenApi\Factories\SecuritySchemeFactory;

class SecurityRequirement extends ParentSecurityRequirement
{
    protected array $multiAuthSecurityScheme = [];

    protected function generate(): array
    {
        if (!empty($this->multiAuthSecurityScheme)) {
            return $this->generateMultiAuth();
        }

        return [parent::generate()];
    }

    /**
     * @param SecurityScheme[] $multiAuthSecurityScheme
     */
    public function multiAuthSecurityScheme(array $multiAuthSecurityScheme): self
    {
        $instance = clone $this;

        $instance->multiAuthSecurityScheme = $multiAuthSecurityScheme;

        return $instance;
    }

    // TODO: skip generating if empty
    private function generateMultiAuth(): array
    {
        return $this->createSecurityRequirements()->map(
            static function ($securityRequirement) {
                if ($securityRequirement instanceof self) {
                    return $securityRequirement->generate();
                }

                return $securityRequirement->map(
                    static function (self $securityRequirement): array {
                        return $securityRequirement->generate();
                    }
                )->collapse();
            }
        )->reduce(
            static function (Collection $carry, $item) {
                if (count($item) > 1) {
                    return $carry->add($item->reduce(
                        static fn (Collection $carry, array $item) => $carry->merge($item),
                        collect()
                    ));
                }

                return $carry->merge($item);
            },
            collect()
        )?->toArray();
    }

    private function createSecurityRequirements(): Collection
    {
        // TODO: cannot have "no security e.g. []" while providing multiple other securities
        // iterate over all $this->securitySchemeFactories items and check if any of them are NoSecurity
        // throw new \Exception('Cannot disable security while providing multiple other securities');
        return collect($this->multiAuthSecurityScheme)
            // if item is a string, then we have to AND the security items
            // if item is an array, then we have to OR the security items
            ->map(function ($securityItem) {
                if (is_string($securityItem)) {
                    $scheme = $this->buildSecurityScheme($securityItem);

                    return self::create()->securityScheme($scheme);
                }

                return collect($securityItem)
                    ->map(function ($securityScheme) {
                        $scheme = $this->buildSecurityScheme($securityScheme);

                        return self::create()->securityScheme($scheme);
                    });
            });
    }

    /**
     * @param class-string<SecuritySchemeFactory> $securitySchemeFactory
     *
     * @throws BindingResolutionException
     * @throws CircularDependencyException
     */
    private function buildSecurityScheme(string $securitySchemeFactory): SecurityScheme
    {
        assert(class_exists($securitySchemeFactory), new Exception('Security scheme factory does not exist'));

        return app($securitySchemeFactory)->build();
    }
}
