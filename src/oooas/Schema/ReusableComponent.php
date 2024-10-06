<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema;

use MohammadAlavi\LaravelOpenApi\Contracts\Interface\ReusableRefObj as ReusableRefObjContract;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Reference;
use Webmozart\Assert\Assert;

abstract class ReusableComponent extends Reusable implements ReusableRefObjContract
{
    final public static function ref(): Reference
    {
        return Reference::create(self::path());
    }
}
