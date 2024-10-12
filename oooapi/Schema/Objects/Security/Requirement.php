<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Scopes;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes\OAuth2;

final readonly class Requirement
{
    private function __construct(
        private SecuritySchemeFactory $securitySchemeFactory,
        private Scopes $scopes,
    ) {
    }

    public static function create(SecuritySchemeFactory $securitySchemeFactory, Scopes|null $scopes = null): self
    {
        if (is_null($scopes)) {
            return new self($securitySchemeFactory, Scopes::create());
        }

        $securityScheme = $securitySchemeFactory->build();
        if ($securityScheme instanceof OAuth2) {
            if ($securityScheme->containsAllScopes(...$scopes->all())) {
                return new self($securitySchemeFactory, $scopes);
            }

            throw new \InvalidArgumentException('Scopes are not valid for the given security scheme.');
        }
    }

    public function securityScheme(): string
    {
        return $this->securitySchemeFactory::key();
    }

    public function scopes(): array
    {
        return $this->scopes->all();
    }
}
