<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class SecurityRequirement extends ExtensibleObject
{
    protected string|null $securityScheme = null;

    /** @var array<array-key, SecurityScheme|array<array-key, SecurityScheme>> */
    protected array|null $nestedSecurityScheme = null;

    /** @var string[]|null */
    protected array|null $scopes = null;

    public function nestedSecurityScheme(array $nestedSecurityScheme): self
    {
        $clone = clone $this;

        $clone->nestedSecurityScheme = $nestedSecurityScheme;

        return $clone;
    }

    public function scopes(string ...$scopes): static
    {
        $clone = clone $this;

        $clone->scopes = [] !== $scopes ? $scopes : null;

        return $clone;
    }

    private function generateNestedAuth(): array
    {
        // TODO: maybe skip generating if empty?
        $spec = collect($this->nestedSecurityScheme)->map(
            static function (SecurityScheme|array $securityScheme) {
                if ($securityScheme instanceof SecurityScheme) {
                    return self::create()->securityScheme($securityScheme)->toArray();
                }

                return collect($securityScheme)->map(
                    static fn (SecurityScheme $securityScheme): array => self::create()
                        ->securityScheme($securityScheme)
                        ->toArray(),
                )->collapse();
            },
        );

        // merge "and" & "or" security schemes based on https://swagger.io/docs/specification/authentication/
        $fixedSpec = $spec->reduce(static function (Collection $carry, Collection|array $item) {
            if (count($item) > 1) {
                return $carry->add(collect($item)->reduce(
                    static fn (Collection $carry, array $item) => $carry->merge($item),
                    collect(),
                ));
            }

            return $carry->merge($item);
        }, collect());

        return $fixedSpec->toArray();
    }

    protected function toArray(): array
    {
        if ([] !== $this->nestedSecurityScheme && !is_null($this->nestedSecurityScheme)) {
            return $this->generateNestedAuth();
        }

        if ([] !== $this->scopes && !is_null($this->scopes)) {
            return Arr::filter([
                $this->securityScheme => [
                    'scopes' => $this->scopes,
                ],
            ]);
        }

        if (is_null($this->securityScheme)) {
            return [];
        }

        return [Arr::filter([
            $this->securityScheme => [],
        ])];
    }

    public function securityScheme(SecurityScheme|string|null $securityScheme): static
    {
        if ($securityScheme instanceof SecurityScheme) {
            $securityScheme = $securityScheme->objectId;
        }

        $clone = clone $this;

        $clone->securityScheme = $securityScheme;

        return $clone;
    }
}
