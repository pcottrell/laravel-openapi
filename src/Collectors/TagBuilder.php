<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors;

use MohammadAlavi\LaravelOpenApi\Factories\TagFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\Tag;
use Webmozart\Assert\Assert;

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
            ->filter(static fn (string $tag): bool => is_a($tag, TagFactory::class, true))
            ->map(static function (string $tagFactory): Tag {
                /** @var TagFactory $tagFactoryInstance */
                $tagFactoryInstance = app($tagFactory);
                $tag = $tagFactoryInstance->build();
                // TODO: this can be moved to Serve Constructor I think
                Assert::stringNotEmpty($tag->name);

                return $tag;
            })
            ->toArray();
    }
}
