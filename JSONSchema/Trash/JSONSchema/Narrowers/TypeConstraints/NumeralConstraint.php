<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Narrowers\TypeConstraints;

use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Anchor;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Comment;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Defs;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DynamicAnchor;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DynamicRef;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\ExclusiveMaximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\ExclusiveMinimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Id;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Maximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Minimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MultipleOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Ref;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Schema;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Vocabulary;

interface NumeralConstraint extends
    Anchor,
    Comment,
    Defs,
    DynamicAnchor,
    DynamicRef,
    Id,
    Ref,
    Schema,
    Vocabulary,
    ExclusiveMaximum,
    ExclusiveMinimum,
    Maximum,
    Minimum,
    MultipleOf
{
}
