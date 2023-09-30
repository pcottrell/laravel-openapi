<?php

namespace Vyuldashev\LaravelOpenApi\Builders;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Tag;

use function PHPUnit\Framework\assertIsString;
use function PHPUnit\Framework\assertTrue;

class TagBuilder
{
    /**
     * @param array<array-key, class-string<Tag>> $config
     *
     * @return Tag[]
     */
    public function build(array $config): array
    {
        return collect($config)
            ->map(static function ($tag) {
                assertIsString($tag, 'Tag must be a string.');
                assertTrue(class_exists($tag), "Tag class [{$tag}] does not exist or string is not a FQCN.");
                assertTrue(is_a($tag, Tag::class, true), 'Tag class [' . class_basename($tag) . '] must extend ' . Tag::class . '.');

                $tagInstance = $tag::create();

                throw_if(is_null($tagInstance->name), 'Tag name must be set.');

                return $tagInstance;
            })
            ->toArray();
    }
}
