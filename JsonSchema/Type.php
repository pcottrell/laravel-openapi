<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Validation;

final readonly class Type implements Validation
{
    private function __construct(
        private string $type,
    ) {
    }

    /**
     * The JSON null constant.
     */
    public static function null(): self
    {
        return new self('null');
    }

    /**
     * The JSON true or false constants.
     */
    public static function boolean(): self
    {
        return new self('boolean');
    }

    /**
     * A JSON string.
     */
    public static function string(): self
    {
        return new self('string');
    }

    /**
     * A JSON number that represents an integer.
     */
    public static function integer(): self
    {
        return new self('integer');
    }

    /**
     * A JSON number.
     */
    public static function number(): self
    {
        return new self('number');
    }

    /**
     * A JSON object.
     */
    public static function object(): self
    {
        return new self('object');
    }

    /**
     * A JSON array.
     */
    public static function array(): self
    {
        return new self('array');
    }

    public static function keyword(): string
    {
        return 'type';
    }

    public function value(): string
    {
        return $this->type;
    }

    public function equals(self|string $type): bool
    {
        if ($type instanceof self) {
            return $this->type === $type->type;
        }

        return $this->type === $type;
    }
}
