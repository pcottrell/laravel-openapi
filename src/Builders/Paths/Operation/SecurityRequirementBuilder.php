<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections\SecurityFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Security;

readonly class SecurityRequirementBuilder
{
    public function __construct(
        private \MohammadAlavi\LaravelOpenApi\Builders\SecurityRequirementBuilder $securityRequirementBuilder,
    ) {
    }

    /**
     * @param class-string<SecurityFactory>|null $securityFactory
     */
    public function build(string|null $securityFactory): Security
    {
        return $this->securityRequirementBuilder->build($securityFactory);
    }
}
