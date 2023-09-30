<?php

namespace Vyuldashev\LaravelOpenApi\Builders;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use InvalidArgumentException;
use Vyuldashev\LaravelOpenApi\Factories\TagFactory;
use Vyuldashev\LaravelOpenApi\Helpers\BuilderHelper;

class TagBuilder
{
    /**
     * @param array<array-key, class-string<Tag>> $tagFactories
     *
     * @return Tag[]
     */
    public function build(array $tagFactories): array
    {
        return collect($tagFactories)
            ->filter(static fn ($tag) => app($tag) instanceof TagFactory)
            ->map(function (string $tag): Tag {
                /** @var Tag $tag */
                $tag = app($tag)->build();

                throw_if(BuilderHelper::hasInvalidField($tag->toArray(), 'name'), new InvalidArgumentException('Tag name is required.'));

                return $tag;
            })
            ->toArray();
    }
}
