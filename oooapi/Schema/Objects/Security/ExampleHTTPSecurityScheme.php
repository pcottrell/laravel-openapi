<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes\Http;

class ExampleHTTPSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return Http::bearer('Example Security');
    }
}
