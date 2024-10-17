<?php

namespace MohammadAlavi\ObjectOrientedOpenAPI\Schema;

use MohammadAlavi\ObjectOrientedOpenAPI\Exceptions\PropertyDoesNotExistException;
use MohammadAlavi\ObjectOrientedOpenAPI\Extensions\Extension;
use MohammadAlavi\ObjectOrientedOpenAPI\Extensions\Extensions;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generatable;

// TODO: refactor!
//  I mean, I don't even know the the extension supposed to work!
//  I have to read the docs! Also, check if the Extension can be created per object as the docs seems to suggest.
//   Or it is just generated for all objects! Like a global thing!
abstract class ExtensibleObject extends Generatable
{
    private readonly Extensions $extensions;

    final protected function __construct()
    {
        $this->extensions = Extensions::create();
    }

    public function addExtension(Extension ...$extension): static
    {
        $clone = clone $this;

        $clone->extensions->add(...$extension);

        return $clone;
    }

    public function removeExtension(string $name): static
    {
        $clone = clone $this;

        $clone->extensions->remove($name);

        return $clone;
    }

    public function getExtension(string $name): Extension
    {
        return $this->extensions->get($name);
    }

    /** @return Extension[] */
    public function extensions(): array
    {
        return $this->extensions->all();
    }

    // TODO: remove this and use methods instead
    public function __get(string $name): mixed
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        throw new PropertyDoesNotExistException(sprintf('[%s] is not a valid property.', $name));
    }

    public function jsonSerialize(): array
    {
        if ($this->extensions->isEmpty()) {
            return parent::jsonSerialize();
        }

        return Arr::filter([
            ...$this->toArray(),
            ...$this->extensions->jsonSerialize(),
        ]);
    }
}
