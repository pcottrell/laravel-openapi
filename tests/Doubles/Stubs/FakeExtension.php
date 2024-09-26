<?php

namespace Tests\Doubles\Stubs;

use MohammadAlavi\LaravelOpenApi\Factories\ExtensionFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Schema;

class FakeExtension extends ExtensionFactory
{
    public function key(): string
    {
        return 'x-uuid';
    }

    public function value(): Schema
    {
        return Schema::string()->format(Schema::FORMAT_UUID);
    }
}
