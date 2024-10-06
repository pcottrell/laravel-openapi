<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Components;

interface ComponentMiddleware
{
    public function after(Components $components): void;
}
