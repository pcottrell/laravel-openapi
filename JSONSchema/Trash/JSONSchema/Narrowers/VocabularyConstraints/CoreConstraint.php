<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Narrowers\VocabularyConstraints;

use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Anchor;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Comment;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Defs;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DynamicAnchor;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\DynamicRef;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Id;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Ref;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Schema;
use MohammadAlavi\ObjectOrientedJSONSchema\Builders\Vocabulary;

interface CoreConstraint extends
    Anchor,
    Comment,
    Defs,
    DynamicAnchor,
    DynamicRef,
    Id,
    Ref,
    Schema,
    Vocabulary
{
}
