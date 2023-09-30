<?php

namespace Vyuldashev\LaravelOpenApi\Builders;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;
use InvalidArgumentException;
use Vyuldashev\LaravelOpenApi\Factories\TagFactory;

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

                throw_if($this->hasInvalidName($tag), new InvalidArgumentException('Tag name is required.'));

                return $tag;
            })
            ->toArray();
    }

    private function hasInvalidName(Tag $tag): bool
    {
        $tagArray = $tag->toArray();

        return !array_key_exists('name', $tagArray) || empty($tagArray['name']);
    }
}
