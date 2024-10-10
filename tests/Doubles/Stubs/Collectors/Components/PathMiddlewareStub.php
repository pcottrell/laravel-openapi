<?php

namespace Tests\Doubles\Stubs\Collectors\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\PathMiddleware;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\PathItem;

class PathMiddlewareStub implements PathMiddleware
{
    public function before(RouteInformation $routeInformation): void
    {
    }

    public function after(PathItem $pathItem): PathItem
    {
        return $pathItem;
    }
}
