<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Contracts;

use MohammadAlavi\ObjectOrientedOAS\Utilities\Extensions;

/** @property array|null $x */
interface Extensible
{
    public function x(string $key, mixed $value): static;
    public function __get(string $name): mixed;
    public function extensions(): Extensions|null;

    public function getExtensionInstance(): Extensions;
}
