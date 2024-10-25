<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface;

interface SchemaProperty
{
    public static function keyword(): string;
    public function value(): mixed;
}
