<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods;

use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\Anchor;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\Comment;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\Defs;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\DynamicAnchor;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\DynamicRef;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\ExclusiveMaximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\ExclusiveMinimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\Format;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\Id;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\Maximum;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\MaxLength;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\Minimum;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\MinLength;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\MultipleOf;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\Pattern;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\Ref;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\Schema;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\Type;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\UnevaluatedItems;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\UnevaluatedProperties;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations\Vocabulary;

trait BuilderMethods
{
    use Anchor;
    use Comment;
    use Defs;
    use DynamicAnchor;
    use DynamicRef;
    use ExclusiveMaximum;
    use ExclusiveMinimum;
    use Format;
    use Id;
    use Maximum;
    use MaxLength;
    use Minimum;
    use MinLength;
    use MultipleOf;
    use Pattern;
    use Ref;
    use Schema;
    use Type;
    use Vocabulary;
    use UnevaluatedItems;
    use UnevaluatedProperties;
}
