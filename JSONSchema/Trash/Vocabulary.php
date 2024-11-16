<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Keyword;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Id;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Schema;

interface Vocabulary
{
    public function id(): Id;

    public function schema(): Schema;

    /** @return array<array-key, Keyword> */
    public function keywords(): array;
}
