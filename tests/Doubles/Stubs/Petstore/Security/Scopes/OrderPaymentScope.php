<?php

namespace Tests\Doubles\Stubs\Petstore\Security\Scopes;

use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\Scope;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth\ScopeFactory;

final readonly class OrderPaymentScope extends ScopeFactory
{
    public function build(): Scope
    {
        return Scope::create('order:payment', 'Access to order payment details.');
    }
}
