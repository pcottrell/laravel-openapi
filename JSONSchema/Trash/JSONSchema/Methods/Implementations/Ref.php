<?php

namespace MohammadAlavi\ObjectOrientedJSONSchema\Trash\JSONSchema\Methods\Implementations;

use MohammadAlavi\ObjectOrientedJSONSchema\BuilderInterface;
use MohammadAlavi\ObjectOrientedJSONSchema\Dialect\Draft202012;

trait Ref
{
    private \MohammadAlavi\ObjectOrientedJSONSchema\Keywords\Ref|null $ref = null;


    /**
     * Set a static reference to another <a href="https://json-schema.org/learn/glossary#schema">schema</a>.
     * This is useful for avoiding code duplication and promoting modularity when describing complex data structures.
     *
     * @see https://www.learnjsonschema.com/2020-12/core/ref/
     * @see https://json-schema.org/understanding-json-schema/structuring
     */
    public function ref(string $uri): BuilderInterface
    {
        $clone = clone $this;

        $clone->ref = Draft202012::ref($uri);

        return $clone;
    }
}
