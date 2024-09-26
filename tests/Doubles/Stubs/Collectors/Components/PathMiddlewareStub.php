<?php

namespace Tests\Doubles\Stubs\Collectors\Components;

use MohammadAlavi\LaravelOpenApi\Contracts\PathMiddleware;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\PathItem;

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
