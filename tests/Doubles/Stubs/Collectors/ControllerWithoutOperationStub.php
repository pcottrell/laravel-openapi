<?php

namespace Tests\Doubles\Stubs\Collectors;

use MohammadAlavi\LaravelOpenApi\Attributes\PathItem;

#[PathItem]
class ControllerWithoutOperationStub
{
    public function __invoke(): string
    {
        return 'example';
    }
}
