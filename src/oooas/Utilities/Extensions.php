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

    protected array $items = [];

    /**
     * Offset to retrieve.
     *
     * @see https://php.net/manual/en/arrayaccess.offsetget.php
     *
     * @throws ExtensionDoesNotExistException
     */
    public function offsetGet($offset): mixed
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
    public function offsetExists($offset): bool
    {
        return isset($this->items[$this->normalizeOffset($offset)]);
    }

    protected function normalizeOffset(string $offset): string
    {
        if (0 === mb_strpos($offset, 'x-')) {
            return $offset;
        }

        return 'x-' . $offset;
    }

    /**
     * Offset to set.
     *
     * @see https://php.net/manual/en/arrayaccess.offsetset.php
     */
    public function offsetSet($offset, $value): void
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
    public function offsetUnset($offset): void
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
