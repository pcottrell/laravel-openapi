<?php

namespace Tests\Doubles\Stubs\Petstore\Security\Scopes;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Scope;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\ScopeFactory;

final readonly class OrderScope extends ScopeFactory
{
    public function build(): Scope
    {
        return Scope::create('order', 'Full information about orders.');
    }
}
