<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\ArrayBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\EnumBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\IntegerBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\JSONSchema\Extensions\ExtendedBuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\BooleanBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\ConstantBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\NullBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\NumberBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\ObjectBuilder;
use MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders\StringBuilder;

interface Builder extends
    ExtendedBuilderInterface,
    NullBuilder,
    BooleanBuilder,
    StringBuilder,
    IntegerBuilder,
    NumberBuilder,
    ObjectBuilder,
    ArrayBuilder,
    ConstantBuilder,
    EnumBuilder
{
    public function null(): NullBuilder;
    public function boolean(): BooleanBuilder;
    public function string(): StringBuilder;
    public function integer(): IntegerBuilder;
    public function number(): NumberBuilder;
    public function object(): ObjectBuilder;
    public function array(): ArrayBuilder;
    public function constant(mixed $value): ConstantBuilder;
    public function enumerator(mixed ...$value): EnumBuilder;
}
