<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Components;

interface ComponentMiddleware
{
    public function after(Components $components): void;
}
