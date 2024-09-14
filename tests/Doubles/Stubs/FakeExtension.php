<?php

namespace Tests\Doubles\Stubs;

use MohammadAlavi\LaravelOpenApi\Factories\ExtensionFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Schema;

class FakeExtension extends ExtensionFactory
{
    public function key(): string
    {
        return 'uuid';
    }

    public function value(): array|string|Schema|null
    {
        return Schema::string()->format(Schema::FORMAT_UUID);
    }
}
