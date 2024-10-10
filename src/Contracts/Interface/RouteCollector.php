<?php

namespace MohammadAlavi\LaravelOpenApi\Contracts\Interface;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Objects\RouteInformation;

interface RouteCollector
{
    /** @return Collection<int, RouteInformation> */
    public function whereInCollection(string $collection): Collection;

    /** @return Collection<int, RouteInformation> */
    public function all(): Collection;
}
