<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts;

use GoldSpecDigital\ObjectOrientedOAS\Objects\PathItem;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;

interface PathMiddleware
{
    public function before(RouteInformation $routeInformation): void;

    public function after(PathItem $pathItem): PathItem;
}
