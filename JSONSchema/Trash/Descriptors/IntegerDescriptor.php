<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptors;

use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptors\NumeralDescriptor;

final class IntegerDescriptor extends NumeralDescriptor
{
    public static function create(): self
    {
        return parent::integer();
    }
}
