<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Core\Defs;

use MohammadAlavi\ObjectOrientedJSONSchema\Contracts\Interface\Vocabulary\Core;

final readonly class Defs implements Core
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

    public static function keyword(): string
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
