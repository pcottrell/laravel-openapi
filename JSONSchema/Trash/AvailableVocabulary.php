<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash;

use MohammadAlavi\ObjectOrientedJSONSchema\Review\MetaSchema\AvailableVocabulary as AvailableVocabularyInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\Vocabulary;

final readonly class AvailableVocabulary implements AvailableVocabularyInterface
{
    public function __construct(
        private Vocabulary $vocabulary,
        private bool $required,
    ) {
    }

    public function id(): string
    {
        return $this->vocabulary->id();
    }

    public function vocabulary(): Vocabulary
    {
        return $this->vocabulary;
    }

    public function required(): bool
    {
        return $this->required;
    }
}
