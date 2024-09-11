<?php

namespace MohammadAlavi\LaravelOpenApi\Collectors;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Extension as ExtensionAttribute;
use MohammadAlavi\LaravelOpenApi\Factories\ExtensionFactory;
use MohammadAlavi\ObjectOrientedOAS\Objects\BaseObject;

class ExtensionBuilder
{
    public function build(BaseObject $baseObject, Collection $attributes): void
    {
        $attributes
            ->filter(static fn (object $attribute): bool => $attribute instanceof ExtensionAttribute)
            ->each(static function (ExtensionAttribute $extensionAttribute) use ($baseObject): void {
                if (null !== $extensionAttribute->factory && '' !== $extensionAttribute->factory && '0' !== $extensionAttribute->factory) {
                    /** @var ExtensionFactory $factory */
                    $factory = app($extensionAttribute->factory);
                    $key = $factory->key();
                    $value = $factory->value();
                } else {
                    $key = $extensionAttribute->key;
                    $value = $extensionAttribute->value;
                }

                $baseObject->x(
                    $key,
                    $value,
                );
            });
    }
}
