<?php

namespace Tests\Doubles\Fakes\Petstore\Security\Scopes;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Scope;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\ScopeFactory;

final readonly class OrderItemScope extends ScopeFactory
{
    public function build(): Scope
    {
        return Scope::create('order:item', 'Information about items within an order.');
    }
}