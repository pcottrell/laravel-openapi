<?php

namespace MohammadAlavi\LaravelOpenApi\Objects;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityRequirement as ParentSecurityRequirement;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;

class SecurityRequirement extends ParentSecurityRequirement
{
    /** @var array<array-key, SecurityScheme|array<array-key, SecurityScheme>> */
    protected array $nestedSecurityScheme = [];

    /** @param array<array-key, SecurityScheme|array<array-key, SecurityScheme>> $nestedSecurityScheme */
    public function nestedSecurityScheme(array $nestedSecurityScheme): self
    {
        $instance = clone $this;

        $instance->nestedSecurityScheme = $nestedSecurityScheme;

        return $instance;
    }

    protected function toArray(): array
    {
        if ([] !== $this->nestedSecurityScheme) {
            return $this->generateMultiAuth();
        }

        return [parent::toArray()];
    }

    private function generateMultiAuth(): array
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
}
