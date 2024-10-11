<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\Collections;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\Factories\ComponentFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\Security;

interface SecurityFactory extends ComponentFactory
{
    public function build(): Security;
}
