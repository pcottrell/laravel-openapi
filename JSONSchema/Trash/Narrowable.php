<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\HasConstraint;

interface Narrowable
{
    public function all(): BuilderInterface;
    public function groupedBy(): HasConstraint;
}
