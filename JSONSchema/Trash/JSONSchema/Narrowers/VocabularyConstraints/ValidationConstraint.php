<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Narrowers\VocabularyConstraints;

use MohammadAlavi\ObjectOrientedJSONSchema\Builders\ExclusiveMaximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\ExclusiveMinimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Maximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MaxLength;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Minimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MinLength;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MultipleOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Pattern;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Type;

interface ValidationConstraint extends
    ExclusiveMaximum,
    ExclusiveMinimum,
    Maximum,
    MaxLength,
    Minimum,
    MinLength,
    MultipleOf,
    Pattern,
    Type
{
}
