<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operation;

use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;

readonly class TagBuilder
{
    public function __construct(
        private \MohammadAlavi\LaravelOpenApi\Collectors\TagBuilder $tagBuilder,
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
