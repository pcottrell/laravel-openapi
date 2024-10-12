<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Examples\SecuritySchemes;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\SecuritySchemeFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Schemes\Http;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityScheme;

class ExampleHTTPSecurityScheme extends SecuritySchemeFactory
{
    public function build(): SecurityScheme
    {
        return Http::bearer('Example Security');
    }
}
