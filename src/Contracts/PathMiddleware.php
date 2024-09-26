<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts;

use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;

interface PathMiddleware
{
    public function before(RouteInformation $routeInformation): void;

    public function after(PathItem $pathItem): PathItem;
}
