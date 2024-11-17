<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\Descriptors;

final class IntegerDescriptor extends NumeralDescriptor
{
    public static function create(): self
    {
        return parent::integer();
    }
}
