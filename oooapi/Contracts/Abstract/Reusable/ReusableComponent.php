<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Contracts\Abstract\Reusable;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\ReusableRefObj as ReusableRefObjContract;
use MohammadAlavi\ObjectOrientedOpenAPI\Schema\Objects\Reference;

abstract class ReusableComponent extends Reusable implements ReusableRefObjContract
{
    final public static function ref(): Reference
    {
        return Reference::create(self::path());
    }
}