<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface;

use MohammadAlavi\LaravelOpenApi\Collections\Path;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;

interface PathMiddleware
{
    public function before(RouteInformation $routeInformation): RouteInformation;

    public function after(Path $path): Path;
}
