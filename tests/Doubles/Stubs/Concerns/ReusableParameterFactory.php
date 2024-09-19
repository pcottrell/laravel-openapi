<?php

namespace Tests\Doubles\Stubs\Concerns;

use MohammadAlavi\LaravelOpenApi\Concerns\Referencable;
use MohammadAlavi\LaravelOpenApi\Contracts\Reusable;
use MohammadAlavi\LaravelOpenApi\Factories\Component\ParameterFactory;

class ReusableParameterFactory extends ParameterFactory implements Reusable
{
    use Referencable;

    public function build(): array
    {
        return [];
    }
}
