<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema;

use MohammadAlavi\ObjectOrientedJSONSchema\Core\Defs\Def;
use MohammadAlavi\ObjectOrientedJSONSchema\Core\Defs\Defs;
use MohammadAlavi\ObjectOrientedJSONSchema\Core\Ref;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Arr;
use MohammadAlavi\ObjectOrientedOpenAPI\Utilities\Generatable;

final class Core extends Generatable
{
    private Ref|null $ref = null;
    private Defs|null $defs = null;

    private function __construct()
    {
    }

    public function ref(string $value): self
    {
        $clone = clone $this;

        $clone->ref = Ref::create($value);

        return $clone;
    }

    public static function create(): self
    {
        return new self();
    }

    public function defs(Def ...$def): self
    {
        $clone = clone $this;

        $clone->defs = Defs::create(...$def);

        return $clone;
    }

    protected function toArray(): array
    {
        $core = [];
        if ($this->ref) {
            $core[Ref::keyword()] = $this->ref->value();
        }
        if ($this->defs) {
            $core[Defs::keyword()] = $this->defs->value();
        }

        return Arr::filter($core);
    }
}
