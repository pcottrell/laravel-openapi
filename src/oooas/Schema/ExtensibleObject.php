<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Schema;

use MohammadAlavi\LaravelOpenApi\oooas\Extensions\Extension;
use MohammadAlavi\LaravelOpenApi\oooas\Extensions\Extensions;
use MohammadAlavi\ObjectOrientedOAS\Exceptions\PropertyDoesNotExistException;

// TODO: refactor!
//  I mean, I don't even know the the extension supposed to work!
//  I have to read the docs! Also, check if the Extension can be created per object as the docs seems to suggest.
//   Or it is just generated for all objects! Like a global thing!
abstract class ExtensibleObject extends BaseObject
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
        return [
            ...parent::jsonSerialize(),
            ...$this->extensions->jsonSerialize(),
        ];
    }
}
