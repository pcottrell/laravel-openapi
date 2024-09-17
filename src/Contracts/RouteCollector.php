<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;

interface RouteCollector
{
    /** @return Collection<int, RouteInformation> */
    public function getRoutes(): Collection;
}
