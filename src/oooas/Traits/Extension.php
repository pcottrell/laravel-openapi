<?php

namespace MohammadAlavi\LaravelOpenApi\oooas\Traits;

use MohammadAlavi\ObjectOrientedOAS\Exceptions\PropertyDoesNotExistException;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Extensions;
use Webmozart\Assert\Assert;

// TODO: refactor!
trait Extension
{
    private Extensions $extensions;

    public function x(string $key, mixed $value = Extensions::X_EMPTY_VALUE): static
    {
        Assert::stringNotEmpty($key);

        if (Extensions::isExtension($key)) {
            $key = mb_substr($key, 2);
        }

        // TODO: add an add() method to extensions instead of this cancer
        $extensions = $this->getExtensionInstance();
        $extensions[$key] = $value;

        $instance = clone $this;

        $instance->extensions = $extensions;

        return $instance;
    }

    public function extensions(): Extensions
    {
        return $this->getExtensionInstance();
    }

    public function getExtensionInstance(): Extensions
    {
        if (!isset($this->extensions)) {
            $this->extensions = new Extensions();
        }

        return $this->extensions;
    }

    /** @throws PropertyDoesNotExistException */
    public function __get(string $name): mixed
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        // Get all extensions.
        if ('x' === $name) {
            return $this->getExtensionInstance()->toArray();
        }

        // Get a single extension.
        if (Extensions::isExtension($name)) {
            $key = mb_strtolower(substr_replace($name, '', 0, 2));

            if (isset($this->getExtensionInstance()[$key])) {
                return $this->getExtensionInstance()[$key];
            }
        }

        throw new PropertyDoesNotExistException(sprintf('[%s] is not a valid property.', $name));
    }
}
