<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Narrowers\TypeConstraints;

use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Anchor;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Comment;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Defs;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DynamicAnchor;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DynamicRef;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Format;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Id;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MaxLength;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MinLength;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Pattern;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Ref;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Schema;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Vocabulary;

interface StringConstraint extends
    Anchor,
    Comment,
    Defs,
    DynamicAnchor,
    DynamicRef,
    Id,
    Ref,
    Schema,
    Vocabulary,
    Format,
    MaxLength,
    MinLength,
    Pattern
{
}
