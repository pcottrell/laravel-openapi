<?php

namespace Tests\Doubles\Stubs\Collectors\Components;

use MohammadAlavi\LaravelOpenApi\Collections\Path;
use MohammadAlavi\LaravelOpenApi\Contracts\Interface\PathMiddleware;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;

class PathMiddlewareStub implements PathMiddleware
{
    public function before(RouteInformation $routeInformation): RouteInformation
    {
        return $routeInformation;
    }

    public function after(Path $path): Path
    {
        return $path;
    }
}
