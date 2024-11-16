<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Defs;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Keyword;
use MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Defs\Def;

final readonly class Defs implements Keyword
{
    /** @param Def[] $defs */
    private function __construct(
        private array $defs,
    ) {
    }

    public static function create(Def ...$def): self
    {
        return new self($def);
    }

    public static function name(): string
    {
        return '$defs';
    }

    public function value(): array
    {
        $defs = [];
        foreach ($this->defs as $def) {
            $defs[$def->name()] = $def->value();
        }

        return $defs;
    }
}
