<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\v31\Builders;

use MohammadAlavi\ObjectOrientedJSONSchema\Builders\AllOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Anchor;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\AnyOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Comment;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DefaultValue;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Defs;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Deprecated;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Description;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DynamicAnchor;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DynamicRef;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Examples;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Id;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\IsReadOnly;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\IsWriteOnly;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\OneOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Ref;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Schema;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Title;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Vocabulary;

interface SharedBuilder extends
    Anchor,
    Comment,
    Defs,
    DynamicAnchor,
    DynamicRef,
    Id,
    Ref,
    Schema,
    Vocabulary,
    AllOf,
    AnyOf,
    OneOf,
    DefaultValue,
    Deprecated,
    Description,
    Examples,
    IsReadOnly,
    IsWriteOnly,
    Title
{
}
