<?php

namespace Tests\Doubles\Fakes\Petstore\SecuritySchemes;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\SecurityScheme;

class BearerTokenSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return SecurityScheme::create()
            ->type(SecurityScheme::TYPE_HTTP)
            ->scheme('bearer');
    }
}
