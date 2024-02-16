<?php

namespace MohammadAlavi\LaravelOpenApi\Builders\Paths\Operation;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;

class TagBuilder
{
    public function __construct(
        private readonly \MohammadAlavi\LaravelOpenApi\Builders\TagBuilder $tagBuilder,
    ) {
    }

    /**
     * @return Tag[]
     */
    public function build(array $tagFactories): array
    {
        return $this->tagBuilder->build($tagFactories);
    }
}
