<?php

namespace Vyuldashev\LaravelOpenApi\Builders\Paths\Operation;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;

class TagBuilder
{
    public function __construct(
        private readonly \Vyuldashev\LaravelOpenApi\Builders\TagBuilder $tagBuilder,
    ) {
    }

    /**
     * @return string[]
     */
    public function build(array $tags): array
    {
        return collect($this->tagBuilder->build($tags))->map(static fn (Tag $tag) => $tag->name)->toArray();
    }
}
