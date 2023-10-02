<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Components;

interface ComponentMiddleware
{
    public function after(Components $components): void;
}
