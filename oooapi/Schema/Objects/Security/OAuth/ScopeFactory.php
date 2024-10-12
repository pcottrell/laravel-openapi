<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\SimpleCreator;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\SimpleCreatorTrait;

readonly abstract class ScopeFactory implements SimpleCreator
{
    use SimpleCreatorTrait;

    abstract public function build(): Scope;
}
