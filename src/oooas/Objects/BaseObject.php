<?php

namespace MohammadAlavi\ObjectOrientedOAS\Objects;

use MohammadAlavi\ObjectOrientedOAS\Exceptions\PropertyDoesNotExistException;
use MohammadAlavi\ObjectOrientedOAS\Utilities\Extensions;
use Webmozart\Assert\Assert;

/** @property array|null $x */
abstract class BaseObject implements \JsonSerializable
{
    protected string|null $ref = null;
    protected Extensions $extensions;

    public function __construct(protected string|null $objectId = null)
    {
        $this->extensions = new Extensions();
    }

    public static function create(string|null $objectId = null): static
    {
        return new static($objectId);
    }

    public static function ref(string $ref, string|null $objectId = null): static
    {
        $static = new static($objectId);

        $static->ref = $ref;

        return $static;
    }

    public function objectId(string|null $objectId): static
    {
        $instance = clone $this;

        $instance->objectId = $objectId;

        return $instance;
    }

    public function x(string $key, $value = Extensions::X_EMPTY_VALUE): static
    {
        Assert::stringNotEmpty($key);

        if ($this->prefixed($key)) {
            $key = mb_substr($key, 2);
        }

        $instance = clone $this;

        $instance->extensions[$key] = $value;

        return $instance;
    }

    /** @throws \JsonException */
    public function toJson(int $options = 0): string
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | $options);
    }

    public function toArray(): array
    {
        if (!is_null($this->ref)) {
            return ['$ref' => $this->ref];
        }

        return array_merge(
            $this->generate(),
            $this->extensions->toArray(),
        );
    }

    abstract protected function generate(): array;

    /**
     * Specify data which should be serialized to JSON.
     */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }

    /** @throws PropertyDoesNotExistException */
    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }

        // Get all extensions.
        if ('x' === $name) {
            return $this->extensions->toArray();
        }

        // Get a single extension.
        if ($this->prefixed($name)) {
            $key = mb_strtolower(substr_replace($name, '', 0, 2));

            if (isset($this->extensions[$key])) {
                return $this->extensions[$key];
            }
        }

        throw new PropertyDoesNotExistException(sprintf('[%s] is not a valid property.', $name));
    }

    private function prefixed(string $name, string $with = 'x-'): bool
    {
        return 0 === mb_strpos($name, $with);
    }
}
