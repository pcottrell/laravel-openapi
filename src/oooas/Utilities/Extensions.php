<?php

namespace MohammadAlavi\ObjectOrientedOAS\Utilities;

use MohammadAlavi\ObjectOrientedOAS\Exceptions\ExtensionDoesNotExistException;

/**
 * @internal
 *
 * @template T
 *
 * @template-implements \ArrayAccess<string, T>
 */
class Extensions implements \ArrayAccess
{
    public const X_EMPTY_VALUE = 'X_EMPTY_VALUE';
    public const EXTENSION_PREFIX = 'x-';

    protected array $items = [];

    /**
     * Offset to retrieve.
     *
     * @see https://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @throws ExtensionDoesNotExistException
     */
    public function offsetGet(mixed $offset): mixed
    {
        if (!$this->offsetExists($offset)) {
            throw new ExtensionDoesNotExistException(sprintf('[%s] is not a valid extension.', $offset));
        }

        return $this->items[$this->normalizeOffset($offset)];
    }

    /**
     * Whether an offset exists.
     *
     * @see https://php.net/manual/en/arrayaccess.offsetexists.php
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$this->normalizeOffset($offset)]);
    }

    protected function normalizeOffset(string $offset): string
    {
        if (static::isExtension($offset)) {
            return $offset;
        }

        return static::EXTENSION_PREFIX . $offset;
    }

    public static function isExtension(string $value): bool
    {
        return 0 === mb_strpos($value, static::EXTENSION_PREFIX);
    }

    /**
     * Offset to set.
     *
     * @see https://php.net/manual/en/arrayaccess.offsetset.php
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (static::X_EMPTY_VALUE === $value) {
            $this->offsetUnset($offset);

            return;
        }

        $this->items[$this->normalizeOffset($offset)] = $value;
    }

    /**
     * Offset to unset.
     *
     * @see https://php.net/manual/en/arrayaccess.offsetunset.php
     */
    public function offsetUnset(mixed $offset): void
    {
        if (!$this->offsetExists($offset)) {
            return;
        }

        unset($this->items[$this->normalizeOffset($offset)]);
    }

    public function toArray(): array
    {
        return $this->items;
    }
}
