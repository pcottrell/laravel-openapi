<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Arr;

class SecurityRequirement extends ExtensibleObject
{
    protected string|null $securityScheme = null;

    /** @var string[]|null */
    protected array|null $scopes = null;

    public function securityScheme(SecurityScheme|string|null $securityScheme): static
    {
        if ($securityScheme instanceof SecurityScheme) {
            $securityScheme = $securityScheme->objectId;
        }

        $instance = clone $this;

        $instance->securityScheme = $securityScheme;

        return $instance;
    }

    public function scopes(string ...$scopes): static
    {
        $instance = clone $this;

        $instance->scopes = [] !== $scopes ? $scopes : null;

        return $instance;
    }

    protected function toArray(): array
    {
        return Arr::filter([
            $this->securityScheme => $this->scopes ?? [],
        ]);
    }
}
