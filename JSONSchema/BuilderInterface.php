<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema;

use MohammadAlavi\ObjectOrientedJSONSchema\Builders\AdditionalProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\AllOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Anchor;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\AnyOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Comment;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Constant;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DefaultValue;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Defs;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DependentRequired;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Deprecated;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Description;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DynamicAnchor;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DynamicRef;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Enum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Examples;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\ExclusiveMaximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\ExclusiveMinimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Format;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Id;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\IsReadOnly;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\IsWriteOnly;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Items;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Maximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MaxContains;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MaxItems;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MaxProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MinContains;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MinItems;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MinProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\OneOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Properties;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Required;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Title;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\UniqueItems;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MaxLength;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Minimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MinLength;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\MultipleOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Pattern;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Ref;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Schema;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Type;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\UnevaluatedItems;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\UnevaluatedProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Vocabulary;

interface BuilderInterface extends
    \JsonSerializable,
    Anchor,
    Comment,
    Defs,
    DynamicAnchor,
    DynamicRef,
    Id,
    Ref,
    Schema,
    Vocabulary,
    UnevaluatedItems,
    UnevaluatedProperties,
    ExclusiveMaximum,
    ExclusiveMinimum,
    Format,
    Maximum,
    MaxLength,
    Minimum,
    MinLength,
    MultipleOf,
    Pattern,
    Type,
    MaxContains,
    MinContains,
    UniqueItems,
    MaxItems,
    MinItems,
    Items,
    AllOf,
    AnyOf,
    OneOf,
    AdditionalProperties,
    Properties,
    DependentRequired,
    MaxProperties,
    MinProperties,
    Required,
    DefaultValue,
    Deprecated,
    Description,
    Examples,
    IsReadOnly,
    IsWriteOnly,
    Title,
    Constant,
    Enum
{
}
