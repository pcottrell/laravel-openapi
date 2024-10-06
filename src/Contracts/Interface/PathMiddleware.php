<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface;

use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;

interface PathMiddleware
{
    public function before(RouteInformation $routeInformation): void;

    public function after(PathItem $pathItem): PathItem;
}
