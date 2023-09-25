<?php

namespace Vyuldashev\LaravelOpenApi\Factories;

abstract class ExtensionFactory
{
    abstract public function key(): string;

    /**
     * @return string|array|null
     */
    abstract public function value();
}
