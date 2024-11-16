<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Review\MetaSchema;

use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Vocabulary;

interface AvailableVocabulary
{
    public function id(): string;

    public function vocabulary(): Vocabulary;

    public function required(): bool;
}
