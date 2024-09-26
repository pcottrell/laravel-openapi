<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors\Paths\Operations;

use MohammadAlavi\LaravelOpenApi\oooas\Schema\Objects\Tag;

readonly class TagBuilder
{
    public function __construct(
        private \MohammadAlavi\LaravelOpenApi\Collectors\TagBuilder $tagBuilder,
    ) {
    }

    /** @return Tag[] */
    public function build(array $tagFactories): array
    {
        return $this->tagBuilder->build($tagFactories);
    }
}
