<?php

namespace Tests\Doubles\Stubs\Concerns;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\Components\ReusableParameterFactory as AbstractReusableParameterFactory;

class ReusableParameterFactory extends AbstractReusableParameterFactory
{
    public function build(): array
    {
        return [];
    }
}
