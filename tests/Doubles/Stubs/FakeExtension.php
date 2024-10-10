<?php

namespace Tests\Doubles\Stubs;

use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\ExtensionFactory;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Schema;

class FakeExtension extends ExtensionFactory
{
    public function key(): string
    {
        return 'x-uuid';
    }

    public function value(): Schema
    {
        return Schema::string('string_test')->format(Schema::FORMAT_UUID);
    }
}
