<?php

namespace MohammadAlavi\LaravelOpenApi\Builders;

use Illuminate\Support\Collection;
use MohammadAlavi\LaravelOpenApi\Attributes\Extension as ExtensionAttribute;
use MohammadAlavi\LaravelOpenApi\Contracts\Abstract\Factories\ExtensionFactory;
use MohammadAlavi\LaravelOpenApi\oooas\Extensions\Extension;
use MohammadAlavi\LaravelOpenApi\oooas\Schema\ExtensibleObject;

class ExtensionBuilder
{
    public function build(ExtensibleObject $extensibleObject, Collection $attributes): void
    {
        $attributes
            ->filter(static fn (object $attribute): bool => $attribute instanceof ExtensionAttribute)
            ->each(static function (ExtensionAttribute $extensionAttribute) use ($extensibleObject): void {
                if (
                    !is_null($extensionAttribute->factory)
                    && '' !== $extensionAttribute->factory
                    && '0' !== $extensionAttribute->factory
                ) {
                    /** @var ExtensionFactory $factory */
                    $factory = app($extensionAttribute->factory);
                    $key = $factory->key();
                    $value = $factory->value();
                } else {
                    $key = $extensionAttribute->key;
                    $value = $extensionAttribute->value;
                }

                $extensibleObject->addExtension(Extension::create($key, $value));
            });
    }
}
