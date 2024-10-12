<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\OAuth;

use MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Interface\SimpleCreator;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Security\SecurityRequirement;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\SimpleCreatorTrait;

readonly abstract class SecurityRequirementFactory implements SimpleCreator
{
    use SimpleCreatorTrait;

    abstract public function build(): SecurityRequirement;
}
